<?php
/**
 * Mail application component
 * Класс компонента Mail:
 *
 * @category YupeApplicationComponent
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Mail application component
 * Класс компонента Mail:
 *
 * @category YupeApplicationComponent
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class YMail extends CApplicationComponent
{
    /**
     * Функция отправки сообщения:
     *
     * @param string $from   - адрес отправителя
     * @param string $to     - адрес получателя
     * @param string $theme  - тема письма
     * @param string $body   - тело письма
     * @param bool   $isText - является ли тело письма текстом
     *
     * @return bool отправилось ли письмо
     **/
    public function send($from, $to, $theme, $body, $isText = false)
    {
        $headers = "From: {$from}\r\nReply-To: {$from}";
        $body    = str_replace("\n.", "\n..", wordwrap($body, 70));

        if (!$isText)
            $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n" . $headers;

        return @mail($to, '=?UTF-8?B?' . base64_encode($theme) . '?=', $body, $headers);
    }
}