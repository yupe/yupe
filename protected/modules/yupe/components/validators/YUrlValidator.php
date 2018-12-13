<?php
/**
 * Валидатор url, корректо воспринимает кирилические адреса
 *
 * @author Anton Kucherov <idexter.ru@gmail.com>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.yupe.components.validators
 * @since 0.1
 *
 */

namespace yupe\components\validators;

use CUrlValidator;

/**
 * Class YUrlValidator
 * @package yupe\components\validators
 */
class YUrlValidator extends CUrlValidator
{
    /**
     * @var string
     */
    public $pattern = '/^{schemes}:\/\/(([A-ZА-Я0-9][A-ZА-Я0-9_-]*)(\.[A-ZА-Я0-9][A-ZА-Я0-9_-]*)+)/iu';
    /**
     * @var string
     */
    public $clientPattern = '/^{schemes}:\/\/(([A-ZА-Я0-9][A-ZА-Я0-9_-]*)(\.[A-ZА-Я0-9][A-ZА-Я0-9_-]*)+)/i';

    /**
     * @param \CModel $object
     * @param string $attribute
     */
    public function clientValidateAttribute($object, $attribute)
    {
        $this->pattern = $this->clientPattern;
        parent::clientValidateAttribute($object, $attribute);
    }
}
