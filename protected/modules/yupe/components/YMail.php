<?php
class YMail extends CComponent
{
    public function init()
    {
    }

    public function send($from, $to, $theme, $body, $isText = false)
    {
        $headers = "From: {$from}\r\nReply-To: {$from}";
        $body = wordwrap($body, 70);
        $body = str_replace("\n.", "\n..", $body);
        if (!$isText)
            $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n" . $headers;
        return mail($to, '=?UTF-8?B?' . base64_encode($theme) . '?=', $body, $headers);
    }
}