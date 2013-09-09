<?php
/**
* Url Validator for Yupe with Russian and UTF-8 support.
*
* @author Anton Kucherov <idexter.ru@gmail.com>
*/

class YUrlValidator extends CUrlValidator
{
    public $pattern = '/^{schemes}:\/\/(([A-ZА-Я0-9][A-ZА-Я0-9_-]*)(\.[A-ZА-Я0-9][A-ZА-Я0-9_-]*)+)/iu';
    public $clientPattern = '/^{schemes}:\/\/(([A-ZА-Я0-9][A-ZА-Я0-9_-]*)(\.[A-ZА-Я0-9][A-ZА-Я0-9_-]*)+)/i';

    public function clientValidateAttribute($object,$attribute)
    {
        $this->pattern = $this->clientPattern;
        parent::clientValidateAttribute($object,$attribute);
    }
}