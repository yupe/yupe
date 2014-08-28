<?php
/**
 * Валидатор url, корректо воспринимает кирилические адреса
 *
 * @author Anton Kucherov <idexter.ru@gmail.com>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.yupe.components.validators
 * @since 0.1
 *
 */

namespace yupe\components\validators;

use CUrlValidator;

class YUrlValidator extends CUrlValidator
{
    public $pattern = '/^{schemes}:\/\/(([A-ZА-Я0-9][A-ZА-Я0-9_-]*)(\.[A-ZА-Я0-9][A-ZА-Я0-9_-]*)+)/iu';
    public $clientPattern = '/^{schemes}:\/\/(([A-ZА-Я0-9][A-ZА-Я0-9_-]*)(\.[A-ZА-Я0-9][A-ZА-Я0-9_-]*)+)/i';

    public function clientValidateAttribute($object, $attribute)
    {
        $this->pattern = $this->clientPattern;
        parent::clientValidateAttribute($object, $attribute);
    }
}
