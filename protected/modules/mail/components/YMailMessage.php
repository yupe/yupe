<?php
/**
 * MailMessage application component
 * Класс компонента MailMessage:
 *
 * @category YupeApplicationComponent
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * MailMessage application component
 * Класс компонента MailMessage:
 *
 * @category YupeApplicationComponent
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class YMailMessage extends CApplicationComponent
{
    public $mailComponent = 'mail';
    private $_mail;

    /**
     * getMailComponent:
     *
     * @return nothing
     **/
    protected function getMailComponent()
    {
        if ($this->_mail !== null)
            return $this->_mail;
        else if (($id = $this->mailComponent) !== null) {
            if ($this->_mail = Yii::app()->getComponent($id))
                return $this->_mail;
        }
        throw new CException(Yii::t('MailModule.mail', 'Компонент YMailMessage.mailComponent не работает!'));
    }

    /**
     * setMailComponent:
     *
     * @param component $value - компонент
     *
     * @return nothing
     **/
    public function setMailComponent($value)
    {
        $this->_mail = $value;
    }

    /**
     * raiseMailEvent:
     *
     * @param string $code - код
     * @param array  $data - данные
     *
     * @return bool
     **/
    public function raiseMailEvent($code, array $data)
    {
        $mailEvent = MailEvent::model()->with('templates')->find(
            array(
                'condition' => 't.code = :code',
                'params'    => array(':code' => $code),
            )
        );

        if (!$mailEvent)
            throw new CException(Yii::t('MailModule.mail', 'MailEvent c кодом "{code}" не найден!'), array(':code' => $code));

        if (!count($mailEvent->templates))
            throw new CException(Yii::t('MailModule.mail', 'MailEvent c кодом "{code}" не содержит ни одного активного шаблона!'), array(':code' => $code));

        foreach ($mailEvent->templates as $template) {
            $parsedData = $this->parseTemplate($template, $data);

            if (!$this->getMailComponent()->send($parsedData['from'], $parsedData['to'], $parsedData['theme'], $parsedData['body']))
               throw new CException(Yii::t('MailModule.mail', 'Ошибка отправка почты!'));
        }
        return true;
    }

    /**
     * sendTemplate:
     *
     * @param string $code - код
     * @param array  $data - данные
     *
     * @return bool
     **/
    public function sendTemplate($code, array $data)
    {
        $template = MailTemplate::model()->find(
            array(
                'condition' => 't.code = :code',
                'params'    => array(':code' => $code),
            )
        );

        if (!$template)
            throw new CException(Yii::t('MailModule.mail', 'Шаблон с кодом "{code}" не найден!'), array('{code}' => $code));

        $parsedData = $this->parseTemplate($template, $data);

        if (!$this->getMailComponent()->send($parsedData['from'], $parsedData['to'], $parsedData['theme'], $parsedData['body']))
               throw new CException(Yii::t('MailModule.mail', 'Ошибка отправка почты!'));
        return true;
    }

    /**
     * sendTemplate:
     *
     * @param \MailTemplate $template - класс темы
     * @param array $data     - данные
     *
     * @return string mail text body
     */
    public function parseTemplate(MailTemplate $template, array $data)
    {
        return str_replace(
            array_keys($data), array_values($data), array(
                'to'    => $template->to,
                'from'  => $template->from,
                'theme' => $template->theme,
                'body'  => $template->body,
            )
        );
    }
}