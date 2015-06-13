<?php

/**
 * Mail application component
 * Класс компонента Mail:
 *
 * @category YupeApplicationComponent
 * @package  yupe.modules.mail.components
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

namespace yupe\components;

use CApplicationComponent;

class Mail extends CApplicationComponent
{
    /**
     * @var \PHPMailer
     */
    private $_mailer;

    /**
     * Method to send mail: ("mail", "sendmail", or "smtp").
     * @var string
     */
    public $method = 'mail';

    /**
     * Smtp settings. Associative array. Required on method = smtp.
     *
     * array(
     *      'host' => 'example.com',
     *      'username' => 'username',
     *      'password' => '*******'
     * );
     * @var array
     */
    public $smtp;

    /**
     * Layout of the email body
     * @var string
     */
    public $layout;

    public function init()
    {
        $this->_mailer = new \PHPMailer();

        switch ($this->method) {
            case 'smtp':
                $this->_mailer->isSMTP();
                $this->_mailer->Host = $this->smtp['host'];
                if (!empty($this->smtp['username'])) {
                    $this->_mailer->SMTPAuth = true;
                    $this->_mailer->Username = $this->smtp['username'];
                    $this->_mailer->Password = $this->smtp['password'];
                } else {
                    $this->_mailer->SMTPAuth = false;
                }
                if (isset($this->smtp['port'])) {
                    $this->_mailer->Port = $this->smtp['port'];
                }
                if (isset($this->smtp['secure'])) {
                    $this->_mailer->SMTPSecure = $this->smtp['secure'];
                }
                if (isset($this->smtp['debug'])) {
                    $this->_mailer->SMTPDebug = (int)$this->smtp['debug'];
                }
                break;
            case 'sendmail':
                $this->_mailer->isSendmail();

                break;
            default:
                $this->_mailer->isMail();
        }

        $this->_mailer->CharSet = \Yii::app()->charset;

        parent::init();
    }

    public function getMailer()
    {
        return $this->_mailer;
    }

    public function getSubject()
    {
        return $this->_mailer->Subject;
    }

    public function setSubject($subject)
    {
        $this->_mailer->Subject = $subject;
    }

    public function setFrom($address, $name = '')
    {
        $this->_mailer->setFrom($address, $name);
        $this->_mailer->addReplyTo($address, $name);
    }

    public function addAddress($address, $name = '')
    {
        $this->_mailer->addAddress($address, $name);
    }

    public function reset()
    {
        $this->init();
    }

    /**
     * Функция отправки сообщения:
     *
     * @param string $from - адрес отправителя
     * @param string|array $to - адрес(-а) получателя
     * @param string $theme - тема письма
     * @param string $body - тело письма
     * @param bool $isText - является ли тело письма текстом
     *
     * @return bool отправилось ли письмо
     **/
    public function send($from, $to, $theme, $body, $isText = false)
    {
        $this->_mailer->clearAllRecipients();

        $this->setFrom($from);

        if (is_array($to)) {
            foreach ($to as $email) {
                $this->addAddress($email);
            }
        } else {
            $this->addAddress($to);
        }

        $this->setSubject($theme);

        if ($isText) {
            $this->_mailer->Body = $body;
            $this->_mailer->isHTML(false);
        } else {
            $this->_mailer->msgHTML($body, \Yii::app()->basePath);
        }

        try {
            return $this->_mailer->send();
        } catch (\Exception $e) {
            \Yii::log($e->__toString(), \CLogger::LEVEL_ERROR, 'mail');

            return false;
        }
    }
}
