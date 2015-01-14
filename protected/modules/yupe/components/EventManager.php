<?php

namespace yupe\components;

use CApplicationComponent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventManager extends CApplicationComponent
{
    /**
     * @var Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    protected $dispatcher;

    /**
     * @var array
     */
    public $events = [];

    /**
     * @var array
     */
    public $subscribers = [];

    public function init()
    {
        $this->dispatcher = new EventDispatcher();

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->dispatcher->addListener($event, $listener);
            }
        }

        foreach ($this->subscribers as $event => $subscribers) {
            foreach ($subscribers as $subscriber) {
                $this->dispatcher->addSubscriber($subscriber);
            }
        }

        parent::init();
    }

    /**
     * @param $eventName
     * @param Event $event
     *
     * Вызвать событие
     */
    public function fire($eventName, Event $event)
    {
        $this->dispatcher->dispatch($eventName, $event);
    }
}
