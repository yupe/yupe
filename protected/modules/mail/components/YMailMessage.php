<?php
/**
 * MailMessage application component
 * Класс компонента MailMessage:
 *
 * @category YupeApplicationComponent
 * @package  yupe.modules.mail.components
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

Yii::import('application.modules.mail.MailModule');
Yii::import('application.modules.mail.models.*');

/**
 * Class YMailMessage
 */
class YMailMessage extends CApplicationComponent
{
    /**
     * @var string
     */
    public $mailComponent = 'mail';
    /**
     * @var
     */
    private $_mail;

    /**
     * getMailComponent:
     * @throws CException
     * @return nothing
     **/
    protected function getMailComponent()
    {
        if ($this->_mail !== null) {
            return $this->_mail;
        } elseif (($id = $this->mailComponent) !== null) {
            if ($this->_mail = Yii::app()->getComponent($id)) {
                return $this->_mail;
            }
        }
        throw new CException(Yii::t('MailModule.mail', 'Component YMailMessage.mailComponent is not working!'));
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
     * @param  string $code - код
     * @param  array $data - данные
     * @throws CException
     * @return bool
     **/
    public function raiseMailEvent($code, array $data)
    {
        $mailEvent = MailEvent::model()->with('templates')->find(
            [
                'condition' => 't.code = :code',
                'params' => [':code' => $code],
            ]
        );

        if (!$mailEvent) {
            throw new CException(
                Yii::t(
                    'MailModule.mail',
                    'MainEvent with "{code}" code was not found!'
                ), [':code' => $code]
            );
        }

        if (!count($mailEvent->templates)) {
            throw new CException(
                Yii::t(
                    'MailModule.mail',
                    'MainEvent with code "{code}" don\'t contain any of active templates!'
                ), [':code' => $code]
            );
        }

        foreach ($mailEvent->templates as $template) {
            $parsedData = $this->parseTemplate($template, $data);

            if (!$this->getMailComponent()->send(
                $parsedData['from'],
                $parsedData['to'],
                $parsedData['theme'],
                $parsedData['body']
            )
            ) {
                throw new CException(Yii::t('MailModule.mail', 'Error when sending mail!'));
            }
        }

        return true;
    }

    /**
     * sendTemplate:
     *
     * @param  string $code - код
     * @param  array $data - данные
     * @return bool
     * @throws CException
     **/
    public function sendTemplate($code, array $data)
    {
        $template = MailTemplate::model()->find(
            [
                'condition' => 't.code = :code',
                'params' => [':code' => $code],
            ]
        );

        if (!$template) {
            throw new CException(
                Yii::t(
                    'MailModule.mail',
                    'Template with "{code}" was not found!'
                ), ['{code}' => $code]
            );
        }

        $parsedData = $this->parseTemplate($template, $data);

        if (!$this->getMailComponent()->send(
            $parsedData['from'],
            $parsedData['to'],
            $parsedData['theme'],
            $parsedData['body']
        )
        ) {
            throw new CException(Yii::t('MailModule.mail', 'Error when sending mail!'));
        }

        return true;
    }

    /**
     * parseTemplate:
     *
     * Заменяет в шаблоне переменные не их значения
     *
     * @param \MailTemplate $template - модель шаблона
     * @param array $data - данные
     *
     * @return string mail text body
     */
    public function parseTemplate(MailTemplate $template, array $data)
    {
        return str_replace(
            array_keys($data),
            array_values($data),
            [
                'to' => $template->to,
                'from' => $template->from,
                'theme' => $template->theme,
                'body' => $template->body,
            ]
        );
    }
}
