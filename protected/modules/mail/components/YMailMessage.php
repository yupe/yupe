<?php
/**
 * Description of YMailMessage
 *
 * @author andrey
 */
class YMailMessage extends CComponent
{
    public $mailComponent = 'mail';
    private $_mail;

    public function init()
    {
        //
    }

    protected function getMailComponent()
    {
        if ($this->_mail !== null)
            return $this->_mail;
        else if (($id = $this->mailComponent) !== null)
            if ($this->_mail = Yii::app()->getComponent($id))
                return $this->_mail;

        throw new CException(Yii::t('mail','YMailMessage.mailComponent is invalid!'));
    }

    public function setMailComponent($value)
    {
        $this->_mail = $value;
    }

    public function raiseMailEvent($code, array $data)
    {
        $mailEvent = MailEvent::model()->with('templates')->find(array(
            'condition' => 't.code = :code',
            'params'    => array(':code' => $code),
        ));

        if (!$mailEvent)
            throw new CException(Yii::t('mail', 'MailEvent c кодом "{code}" не найден!'), array(':code' => $code));

        if (!count($mailEvent->templates))
            throw new CException(Yii::t('mail', 'MailEvent c кодом "{code}" не содержит ни одного активного шаблона!'), array(':code' => $code));

        foreach ($mailEvent->templates as $template)
        {
           $parsedData = $this->parseTemplate($template, $data);

           if (!$this->getMailComponent()->send($parsedData['from'], $parsedData['to'], $parsedData['theme'], $parsedData['body']))
               throw new CException(Yii::t('mail', 'Ошибка отправка почты!'));
        }

        return true;
    }

    public function sendTemplate($code, array $data)
    {
        $template = MailTemplate::model()->find(array(
            'condition' => 't.code = :code',
            'params'    => array(':code' => $code),
        ));

        if (!$template)
            throw new CException(Yii::t('mail','Шаблон с кодом "{code}" не найден!'), array('{code}' => $code));

        $parsedData = $this->parseTemplate($template, $data);

        if (!$this->getMailComponent()->send($parsedData['from'], $parsedData['to'], $parsedData['theme'], $parsedData['body']))
               throw new CException(Yii::t('mail', 'Ошибка отправка почты!'));

        return true;
    }


    public function parseTemplate(MailTemplate $template, array $data)
    {
        return str_replace(array_keys($data), array_values($data), array(
            'to'    => $template->to,
            'from'  => $template->from,
            'theme' => $template->theme,
            'body'  => $template->body,
        ));
    }
}