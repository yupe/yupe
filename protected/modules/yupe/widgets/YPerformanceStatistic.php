<?php

class YPerformanceStatistic extends YWidget
{
    //@TODO переделать для использования темы оформления
    public function run()
    {
	$dbStat = Yii::app()->db->getStats();
	
    $memory = round(Yii::getLogger()->memoryUsage / 1024 / 1024, 3);
    $time   = round(Yii::getLogger()->executionTime, 3);
		
	echo '<div class="stat" id="stat">';
	if(Yii::app()->db->enableParamLogging == true || Yii::app()->db->enableProfiling == true){
		echo 'запросов: ' . $dbStat[0];
		echo 'время: ' . $dbStat[1] . '</div>';
	}
    echo <<<EOF
        <div>память: {$memory}
        выполнение: {$time}
    </div>
EOF;
    }

}