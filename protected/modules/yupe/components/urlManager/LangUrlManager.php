<?php
/**
 * LangUrlManager - альтернативный менеджер урлов с поддержкой языков
 * при инициализации добавляет к существующим правилам маршрутизации
 * правила для выбора языков в началае пути.
 * То есть, если рассматривать на примере - /<controller>/<index>,
 * то в случае обработки мы получим дополнительное правило:
 * /<language>/<controller>/<action>.
 * Добавленный параметр используется в LanguageBehavior
 *
 * @category YupeComponent
 * @package  yupe.modules.yupe.components.urlManager
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 */
namespace yupe\components\urlManager;

use CUrlManager;
use yupe\widgets\YFlashMessages;
use Exception;
use Yii;
use CHttpCookie;

class LangUrlManager extends CUrlManager
{
    public $languages;
    public $langs;
    public $langParam         = 'language';
    public $languageInPath    = true;
    public $preferredLanguage = false;

    private $_appLang = false;

    /**
     * Инициализация компонента:
     * Здесь мы дополняем правила маршрутизации,
     * в соответствии с существующими языками,
     * если языков используется всего один, то
     * обработка не требуется.
     * 
     * @return parent::init()
     */
    public function init()
    {
        // Получаем список языков:
        $this->getLangs();

        // Если используемых языков меньше двух,
        // то нам сойдёт и стандартный urlManager:
        if (count($this->languages) < 2){
            return parent::init();
        }

        // Если указаны - добавляем правила для обработки, иначе ничего не трогаем вообще
        if ($this->languageInPath) {

            // Применяем преобразование, для строки с языками:
            $langs = str_replace(',', '|', $this->langs);

            // Обходим массив правил и выполняем
            // преобразования для новых правил:
            $newRules = array();

            foreach ($this->rules as $rule => $p) {
                $rule = ($rule[0] == '/'
                    ? '/<' . $this->langParam . ':(' . $langs. ')>'
                    : '<' . $this->langParam . ':(' . $langs . ')>/'
                ) . $rule;
                $newRules[$rule] = $p;
            }

            // Добавляем новые правила:
            $this->rules = array_merge(
                $newRules, $this->rules
            );

            try {
                // Получаем ответ от parent::init()
                // для последующего возврата:
                $parentInit = parent::init();

                // Запускаем процесс обработки правил
                // маршрутизации:
                $this->processRules();   
            } catch (Exception $e) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }

            return isset($parentInit) ? $parentInit : null;
        }

        return parent::init();
    }

    /**
     * Получаем язык приложения:
     * 
     * @return string
     */
    public function getAppLang()
    {
        if ($this->_appLang === false) {
            // Берём язык системы, иначе,
            // если происходит ошибка
            // берём сорсовый
            try {
                $this->_appLang = Yii::app()->getModule('yupe')->defaultLanguage
                                ?: $this->_appLang = Yii::app()->sourceLanguage;;
            } catch (Exception $e) {
                $this->_appLang = Yii::app()->sourceLanguage;
            }
        }

        return $this->_appLang;
    }

    /**
     * Метод получения списка системных языков
     * 
     * @return void
     */
    public function getLangs()
    {
        // Получаем из настроек доступные языки:
        $this->langs = Yii::app()->getModule('yupe')->availableLanguages;

        // Разделяем на массив и удаляем пустые элементы:
        $this->languages = explode(",", $this->langs);
    }

    /**
     * Метод создания URL.
     * Здесь немного поправлена логика для работы
     * с подмножеством языков:
     * 
     * @param string $route     - маршрут к обработке
     * @param array  $params    - список GET параметров
     * @param string $ampersand - маркер отделения пар имя-значение в URL.
     *                            По умолчанию '&'.
     * 
     * @return string parent::createUrl()
     */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        // Обновляем список языков, ведь он мог измениться:
        $this->getLangs();

        // Если используемых языков менее двух или параметр
        // $this->languages не массив языков, обработка не 
        // требуется
        if (count($this->languages) < 2 || !is_array($this->languages)) {
            return parent::createUrl($route, $params, $ampersand);
        }

        // Если язык не указан - берем текущий
        isset($params[$this->langParam]) or ($params[$this->langParam] = Yii::app()->language);

        // Если указан "нативный" язык и к тому же он текущий,
        // то делаем URL без него, т.к. он соответсвует пустому пути:
        if (($this->getAppLang() == $params[$this->langParam]) && ($params[$this->langParam] == Yii::app()->language)) {
            unset($params[$this->langParam]);
        }

        return parent::createUrl($route, $params, $ampersand);
    }

    /**
     * Выполняет очистку адреса от языка
     *
     * @param string $url   - URL к очистке
     * @param string $param - параметры
     * 
     * @return string обработанную строку адреса
     */
    public function getCleanUrl($url, $param = false)
    {
        // Если в URL имеются параметры, получаем их:
        if (strstr($url, '?') !== false) {
            list($url, $param) = explode("?", $url);
        }

        // Убираем homeUrl из адреса:
        $url = preg_replace(
            "#^(" . Yii::app()->getRequest()->scriptUrl . "|" . Yii::app()->getRequest()->baseUrl . ")#", '', $url
        );
        
        // Убираем из пути адреса языковой параметр
        if ($url != '' && $url != '/') {
            if ($url[0] == '/')
                $url = substr($url, 1);
            if ($url[strlen($url) - 1] != '/')
                $url .= '/';
            $url = preg_replace("#^(" . implode("|", $this->languages) . ")/#", '', $url);
        }
        // Убираем косую черту в конце пути для единоообразия
        if ($url != '' && $url[strlen($url) - 1] == '/') {
            $url = substr($url, 0, strlen($url) - 1);
        }
        
        // Убираем из GET-парамметров адреса языковой парамметр
        if ($param != false) {
            parse_str($param, $param);
            if (isset($param[$this->langParam])) {
                unset($param[$this->langParam]);
            }
            if ($param != array()) {
                $url .= '?' . http_build_query($param);
            }
        }
        return $url;
    }

    /**
     * При принудительном изменении языка, определяет как добавлять язык
     * первый парамметр url должен быть очищен от языкового парамметра с помощью getCleanUrl.
     *
     * @param string $url  - Url для обработки
     * @param string $lang - язык, по умолчанию - false
     * 
     * @return string обработанную строку адреса
     */
    public function replaceLangUrl($url, $lang = false)
    {
        return $lang !== false
            ? (
                $this->languageInPath
                    ? $lang . ($url != '' ? '/' . $url : '')
                    : $url . (strstr($url, '?') ? '&' : '?') . $this->langParam . '=' . $lang
            )
            : $url;
    }
}