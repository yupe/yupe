<?php
/**
 * Notifier Class
 *
 * @category YupeComponents
 * @package  yupe.modules.comment.components
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

namespace application\modules\comment\components;


use Yii;
use CHtmlPurifier;
use CApplicationComponent;

class Notifier extends CApplicationComponent
{
    /**
     * Comment Notifier Function
     *
     * @param CModelEvent $event - инстанс события
     *
     * @return bool отправилось ли письмо
     **/
    public static function notify(NewCommentEvent $event = null)
    {
        $htmlPurifier = new CHtmlPurifier;
        $htmlPurifier->options = array(
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
        );

        // Если не установлен модуль Mail, то ничего не отправляем
        if (!Yii::app()->hasModule('mail')) {
            return false;
        }

        return Yii::app()->mail->send(
            // От кого (отправитель комментария):
            $event->comment->email,
            // Кому (указывается в настройках модуля):
            $event->module->email,
            // Тема письма:
            Yii::t(
                'CommentModule.comment',
                'New post was created on site "{app}"!',
                array('{app}' => Yii::app()->name)
            ),
            // Текст письма (сам комментарий и немного информации):
            Yii::t(
                'CommentModule.comment',
                'Comment was created on your site:
               Author: {author}
               Model/ID: {model}/{model_id}
               Comment text:  {comment}',
                array(
                    '{author}'   => isset($event->comment->author->nick_name) ? $event->comment->author->nick_name : $event->comment->author,
                    '{model}'    => $event->comment->model,
                    '{model_id}' => $event->comment->model_id,
                    '{comment}' => $htmlPurifier->purify(
                            $event->comment->text
                        ),
                )
            )
        );
    }
}