<?php

namespace yupe\components;

use Yii;
use CApplicationComponent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventManager extends CApplicationComponent
{
    /**
     * @var Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    protected $dispatcher;

    public $events = array();

    public function init()
    {
        $this->dispatcher = new EventDispatcher();

        foreach($this->events as $event => $listeners) {
            foreach($listeners as $listener){
                $this->dispatcher->addListener($event, $listener);
            }
        }

        parent::init();
    }

    public function fire($eventName, Event $event)
    {
        $this->dispatcher->dispatch($eventName, $event);
    }
} 