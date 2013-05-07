<?php

class YPerformanceStatistic extends YWidget
{
    public function run()
    {
        $dbStat = Yii::app()->db->getStats();
        $memory = round(Yii::getLogger()->memoryUsage / 1024 / 1024, 3);
        $time   = round(Yii::getLogger()->executionTime, 3);
        $this->render('stat',array('dbStat' => $dbStat, 'time' => $time, 'memory' => $memory));
    }
}