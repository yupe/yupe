<?php
/**
 * YQueueMail компонент для отправки почты через очередь
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.queue.components
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 * @abstract
 *
 */
class YQueueMail extends yupe\components\Mail
{
    public $queueComponent    = 'queue';
    public $queueMailWorkerId = 1;
    private $_queue;

    public function init()
    {
        parent::init();
    }

    public function getQueueComponent()
    {
        if ($this->_queue !== null) {
            return $this->_queue;
        }
        else if (($id = $this->queueComponent) !== null)
        {
            if (($this->_queue = Yii::app()->getComponent($id)) instanceof YQueue){
                return $this->_queue;
            }
        }
        throw new Exception(Yii::t('QueueModule.queue', 'YQuemail.queueComponent contains bad identifier of queue component!'));
    }

    public function send($from, $to, $theme, $body, $isText = false)
    {
        return $this->getQueueComponent()->add($this->queueMailWorkerId, array(
            'from'  => $from,
            'to'    => $to,
            'theme' => $theme,
            'body'  => $body,
        ));
    }
}