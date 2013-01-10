<?php
class YQueueMail extends YMail
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
        if ($this->_queue !== null)
            return $this->_queue;
        else if (($id = $this->queueComponent) !== null)
        {
            if (($this->_queue = Yii::app()->getComponent($id)) instanceof YQueue)
                return $this->_queue;
        }
        throw new Exception(Yii::t('QueueModule.queue', 'YQuemail.queueComponent содержит неправильный идентификатор компонента queue!'));
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