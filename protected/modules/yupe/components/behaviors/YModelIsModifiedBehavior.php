<?php
/**
 * Class YModelIsModifiedBehavior
 * Поведение для проверки изменения модели.
 * Также через методы поведения можно получить список изменившихся атрибутов.
 * Удобно использовать для того, чтобы сохранять в базу только изменившиеся модели.
 *
 * Стоит учитывать то, что если атрибут задан через CDbExpression, то он всегда будет считаться изменённым.
 *
 * @author Zalatov A.
 *
 * Атрибуты через геттеры/сеттеры:
 * @property-read array		$oldAttributes			Массив с изначальными атрибутами
 * @property-read bool		$isModified				Флаг, изменились ли атрибуты модели или нет
 * @property-read array		$modifiedAttributes		Массив с изменёнными атрибутами
 */
class YModelIsModifiedBehavior extends CActiveRecordBehavior {
	/**
	 * Атрибуты, которые не надо учитывать при проверке изменения модели
	 * Эти атрибуты можно задать в настройках при подключении поведения.
	 */
	public $exceptAttributes = array(
		'id',
		'insert_stamp',
		'update_stamp',
	);

	/**
	 * Массив с изначальными значениями атрибутов
	 */
	private $_oldAttributes = array();

	/**
	 * Действие при подключении behavior'а к модели
	 *
	 * @author Zalatov A.
	 */
	public function onAttachBehavior() {
		// -- После поиска модели запоминаем значения атрибутов, чтобы потом с ними можно было бы что-нибудь сделать
		$this->owner->attachEventHandler('onAfterFind', array($this, 'onAttachEventHandler'));
		// -- -- -- --
	}

	/**
	 * @param CEvent $event
	 */
	public function onAttachEventHandler($event) {
		$event->sender->setOldAttributes($event->sender->attributes);
	}

	/**
	 * Сеттер для установки значений изначальных атрибутов
	 *
	 * @author Zalatov A.
	 */
	public function setOldAttributes($attributes) {
		$this->_oldAttributes = $attributes;
	}

	/**
	 * Геттер для получения списка значений изначальных атрибутов
	 *
	 * @author Zalatov A.
	 *
	 * @return array
	 */
	public function getOldAttributes() {
		return $this->_oldAttributes;
	}

	/**
	 * Проверка, является ли модель изменённой (хотя бы один атрибут модели был изменён)
	 *
	 * Можно использовать по аналогии с isNewRecord, то есть это "геттер" метод - $this->isChanged вместо $this->getIsChanged()
	 * Проходимся по всем атрибутам ДО и сравниваем с текущими атрибутами
	 *
	 * @author Zalatov A.
	 *
	 * @return bool
	 */
	public function getIsModified() {
		if ($this->owner->isNewRecord) return true;// Новая модель всегда считается изменённой

		$changed = $this->getModifiedAttributes();
		return (count($changed) > 0);
	}

	/**
	 * Получение массива с изменёнными атрибутами
	 * Проходимся по всем атрибутам ДО и сравниваем с текущими атрибутами
	 *
	 * @author Zalatov A.
	 *
	 * @return array
	 */
	public function getModifiedAttributes() {
		$result = array();

		foreach ($this->owner->attributes as $attribute => $new_value) {
			$old_value = null;
			if (isset($this->_oldAttributes[$attribute])) $old_value = $this->_oldAttributes[$attribute];

			if (in_array($attribute, $this->exceptAttributes)) continue;// Если атрибут является исключённым из проверки

			if ($old_value == $new_value) continue;// Если значение не изменилось

			$result[$attribute] = array(
				'old' => $old_value,
				'new' => $new_value,
			);
		}

		return $result;
	}

	/**
	 * Сохранение только изменённых аттрибутов модели
	 *
	 * @author Zalatov A.
	 *
	 * @return bool
	 * @throws CDbException В случае, если модели ещё нет в базе
	 */
	public function saveModifiedAttributes() {
		if ($this->owner->getIsNewRecord()) {
			throw new CDbException(Yii::t('yii', 'The active record cannot be updated because it is new.'));
		}

		$modified_attributes = $this->getModifiedAttributes();
		if (count($modified_attributes) == 0) return true;// Если изменений нет, сразу возвращаем true
		return $this->owner->update(array_keys($modified_attributes));
	}
}