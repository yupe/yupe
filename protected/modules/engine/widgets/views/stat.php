<?php
        echo '<div class="stat" id="stat">';
        if(Yii::app()->db->enableParamLogging == true || Yii::app()->db->enableProfiling == true){
            echo Yii::t('YupeModule.engine','запросов: {qcount}',array('{qcount}' => $dbStat[0]));
            echo Yii::t('YupeModule.engine',' время: {qtime}',array('{qtime}' => round($dbStat[1],3)));
        }
        echo"<div>";
        echo Yii::t('YupeModule.engine','память: {memory}',array('{memory}' => $memory));
        echo Yii::t('YupeModule.engine',' выполнение: {time}',array('{time}' => $time));
        echo"</div>";
?>
