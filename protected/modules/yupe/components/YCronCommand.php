<?php
/**
 * Class YCronCommand
 * Основная команда CRON'а
 *
 * @category YupeModule
 * @package  yupe.modules.yupe.components
 * @author   Zalatov A.
 *
 * Принцип взаимосвязей такой.
 * По CRON'у запускается эта команда.
 * От этой команды наследуются другие команды, например SitemapCommand.
 *
 * В данной реализации, в команды можно передавать аргументы.
 * По-умолчанию, для всех команд вызывается метод actionIndex.
 * Там и надо писать основные алгоритмы.
 *
 * Так как другие команды наследуются от CronCommand, то их можно без проблем запускать отдельно (например, через SSH).
 * Если команда запущена CRON'ом (то есть, из этого класса), то будет проверяться ключ бллокировки.
 * Если же команда запущена отдельно, ключ блокировки также будет проверяться, но будет выдано уведомление.
 * В этом уведомлении можно подтвердить или отменить дальнейшее выполнение команды несмотря на блокировку.
 */

namespace yupe\components;

use Yii;

class YCronCommand extends CConsoleCommand {
	protected $lock_time;// @property int Время блокировки запуска команды (должно быть определено в каждой из команд)
	private $start_time;// @property int Время time() запуска команды
	private $args;// @property array $args Аргументы командной строки
	private $lock_key;// @property string $lock_key Ключ блокировки

	/**
	 * Основной метод
	 *
	 * В этом методе перечислены все команды, которые надо запустить.
	 * Каждая команда сама определяет, по какому расписанию ей запускаться.
	 * Но чтобы она это сделала, в самой команде нужно protected-свойство $lock_time
	 *
	 * @author Zalatov A.
	 */
	public function actionIndex() {
/*
		// -- Карта сайта
		$command = new SitemapCommand($this->name, $this->commandRunner);
		$command->run($this->args);
		// -- -- -- --
*/
	}

	/**
	 * Метод запуска консольной команды
	 * Частично переопределяем метод вызова команды, чтобы завязать запуск на ключ блокировки.
	 *
	 * @author Zalatov A.
	 *
	 * @param array $args Аргументы, указанные в командной строке
	 * @return int
	 */
	public function run($args) {
		// -- Инициализируем команду
		$this->args			= $args;// Запоминаем аргументы - они могут понадобиться
		$this->start_time	= time();// Определяем время запуска команды
		$this->lock_key		= 'cron.lock.' . get_class($this);// Берём ключ блокировки исходя из названия класса

		ini_set('max_execution_time', 1 * 60 * 60);// Увеличиваем время выполнения скрипта до 60 минут
		ini_set('memory_limit', '1500M');// Увеличиваем лимит памяти до 1 500 Мб
		// -- -- -- --

		// -- Если это не CronCommand, а другая команда, вешаем обработчики и проверяем ключ блокировки
		if (get_class($this) != __CLASS__) {
			$this->attachEventHandler('onBeforeAction', 'onBeforeAction');
			$this->attachEventHandler('onAfterAction', 'onAfterAction');

			if ($this->HasLock()) return 0;// Проверяем ключ блокировки и выходим, если прошло недостаточно времени
			Yii::app()->cache->set($this->lock_key, time(), $this->lock_time);// Устанавливаем новую блокировку
		}
		// -- -- -- --

		return parent::run($args);// Передаём управление родительскому методу
	}

	/**
	 * Проверка блокировки запуска
	 *
	 * Метод сам определяем ключ для MemCache.
	 * Если время блокировки не указано, команда НЕ будет выполнена.
	 *
	 * Если команда запущена не из CronCommand, а отдельно (например из консоли), то будет выдано предупреждение на игнорирование блокировки.
	 *
	 * @author Zalatov A.
	 *
	 * @return bool
	 */
	private function HasLock() {
		if (!isset($this->lock_time)) return true;// Если не указано, на сколько ставится блокировка, команду запускать не надо

		$cache_result = Yii::app()->cache->get($this->lock_key);// В кэше хранится время time(), когда была поставлена блокировка

		if ($cache_result === false) return false;// Если кэша нет, значит команду можно запустить

		if ($cache_result + $this->lock_time < time()) return false;// Если время блокировки ключа просрочилось

		if ($this->name == 'cron') return true;// Если блокировка ещё не снята, и команда выполнена из CronCommand, то запускать команду нельзя

		// -- Если команда запущена отдельно, спрашиваем, запускать или нет (попутно выводим информацию о времени)
		$confirm_message = sprintf(
			implode("\n", array(
				'Interval:   %s minutes',
				'Locked ago: %s minutes',
				'Left time:  %s minutes',
				'Run anyway?',
			)),
			str_pad(ceil($this->lock_time								/ 60), 3, ' ', STR_PAD_LEFT),
			str_pad(ceil((time() - $cache_result)						/ 60), 3, ' ', STR_PAD_LEFT),
			str_pad(ceil(($cache_result + $this->lock_time - time())	/ 60), 3, ' ', STR_PAD_LEFT)
		);
		if ($this->confirm($confirm_message) !== true) return true;
		// -- -- -- --

		return false;
	}

	/**
	 * Действие ДО выполнения команды
	 *
	 * Пишем в лог, что команда запущена.
	 *
	 * @author Zalatov A.
	 *
	 * @param CConsoleCommandEvent $event
	 */
	public function onBeforeAction($event) {
		if (get_class($this) == __CLASS__) return;// Исключаем из лога основную команду (CronCommand), которая запускает остальные
		$this->log('Команда запущена');
	}

	/**
	 * Действие ПОСЛЕ выполнения команды
	 *
	 * Пишем в лог, что команда выполнена за столько-то времени.
	 *
	 * @author Zalatov A.
	 *
	 * @param CConsoleCommandEvent $event
	 */
	public function onAfterAction($event) {
		if (get_class($this) == __CLASS__) return;// Исключаем из лога основную команду (CronCommand), которая запускает остальные
		$this->log(sprintf('Команда выполнена за %s сек.', (time() - $this->start_time)));
	}

	/**
	 * Ведение лога
	 *
	 * @author Zalatov A.
	 *
	 * @param string $message Текст лога
	 * @param string $level Уровень
	 */
	protected function log($message, $level = 'info') {
		$category = implode('.', array(
			'cron',
			str_replace('Command', '', basename(get_called_class())),// Извлекаем из имени класса с нэймспэйсом только ту часть, которая нам нужна (\protected\commands\SitemapCommand => Sitemap)
			date('ymd', $this->start_time),
			date('His', $this->start_time),
		));

		echo $this->translit($category . ': ' . $message) . "\n";// Вывод сообщения в консоль
		Yii::log($message, $level, $category);// Запись сообщения в журнал в базу
	}

	/**
	 * Транслит русских букв в английские (для вывода в консоль)
	 *
	 * Некоторые консоли могут не поддерживать русские буквы.
	 * К тому же, некоторые консоли могут не воспринимать UTF-8.
	 *
	 * @author Zalatov A.
	 *
	 * @param string $text Текст, которые надо перевести в транслит
	 * @return string
	 */
	private function translit($text) {
		$src = 'А Б В Г Д Е Ё Ж З И Й К Л М Н О П Р С Т У Ф Х Ц Ч  Ш  Щ  Ъ Ы Ь Э Ю  Я  а б в г д е ё ж з и й к л м н о п р с т у ф х ц ч  ш  щ  ъ ы ь э ю  я';
		$dst = 'A B V G D E E J Z I I K L M N O P R S T U F H C CH SH SH ~ I ~ E YU YA a b v g d e e j z i i k l m n o p r s t u f h c ch sh sh ~ i ~ e yu ya';

		$src = explode(' ', str_replace('  ', ' ', $src));
		$dst = explode(' ', str_replace('  ', ' ', $dst));

		return str_replace($src, $dst, $text);
	}
}