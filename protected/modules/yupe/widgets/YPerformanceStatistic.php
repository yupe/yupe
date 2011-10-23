<?php
class YPerformanceStatistic extends CWidget
{
    public function run()
    {
        $dbStat = Yii::app()->db->getStats();
        $memory = round(Yii::getLogger()->memoryUsage / 1024 / 1024, 3);
        $time = round(Yii::getLogger()->executionTime, 3);
        echo "<div class='stat' id='stat'>
           <div style='float:left;padding-right:5px'> запросов: {$dbStat[0]} </div>
           <div style='float:left;padding-right:5px'> время: {$dbStat[1]} </div>
           <div style='float:left;padding-right:5px'> память: $memory </div>
           <div style='float:left;padding-right:5px'> выполнение: $time </div>
        </div>";
    }
}