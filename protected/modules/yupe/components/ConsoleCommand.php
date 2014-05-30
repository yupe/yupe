<?php

namespace application\modules\yupe\components;

use CConsoleCommand;
use CLogger;
use Yii;

class ConsoleCommand extends CConsoleCommand
{
    public $echo = true;

    public function getLogCategory()
    {
        return __CLASS__;
    }

    public function log($message, $level = CLogger::LEVEL_INFO, $echo = true, $category = null)
    {
        if(null === $category) {
            $category = $this->getLogCategory();
        }

        if($echo || $this->echo) {
            echo "{$message}... \n";
        }

        Yii::log($message, $level, $category);
    }
} 