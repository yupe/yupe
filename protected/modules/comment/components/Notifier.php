<?php
/**
 * File Doc comment
 * Notifier Class:
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

/**
 * Notifier Class:
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
class Notifier
{
    /**
     * Comment Notifier Function
     *
     * @param CModelEvent $event - инстанс события
     *
     * @return bool отправилось ли письмо
     **/
    public function newComment(CModelEvent $event = null)
    {
        /**
         * Отправляем сообщение о добавлении нового комментария
         * на указанный Email в настройках модуля комментариев
         * и добавляем об этом запись в лог-файл:
         **/
        Yii::log(
            Yii::t(
                'CommentModule.comment', "{className}: Отправляем информацию о создании нового комментария на сайте.", array(
                    '{className}' => get_class($this)
                )
            )
        );
        $htmlPurifier = new CHtmlPurifier;
        $htmlPurifier->options = array(
            'HTML.SafeObject'    => true,
            'Output.FlashCompat' => true,
        );
        return Yii::app()->mail->send(
            // От кого (отправитель комментария):
            $event->comment->email,
            // Кому (указывается в настройках модуля):
            $event->module->email,
            // Тема письма:
            Yii::t(
                'CommentModule.comment', 'Добавлена новая запись на сайте "{app}"!', array('{app}' => Yii::app()->name)
            ),
            // Текст письма (сам комментарий и немного информации):
            Yii::t(
                'CommentModule.comment', "На вашем сайте добавлен комментарий:\nАвтор: {author}\nМодель/ID: {model}/{model_id}\nТекст комментария: {comment}", array(
                    '{author}'   => isset($event->comment->author->nick_name) ? $event->comment->author->nick_name : $event->comment->author,
                    '{model}'    => $event->comment->model,
                    '{model_id}' => $event->comment->model_id,
                    '{comment}'  => $htmlPurifier->purify(
                        $event->comment->text
                    ),
                )
            )
        );
    }
}