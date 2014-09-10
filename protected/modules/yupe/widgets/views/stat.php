<?php
echo '<div class="stat" id="stat">';
if (Yii::app()->db->enableParamLogging == true || Yii::app()->db->enableProfiling == true) {
    echo Yii::t('YupeModule.yupe', 'requests: {qcount}', array('{qcount}' => $dbStat[0]));
    echo Yii::t('YupeModule.yupe', ' time: {qtime}', array('{qtime}' => round($dbStat[1], 3)));
}
echo "<div>";
echo Yii::t('YupeModule.yupe', 'memory: {memory}', array('{memory}' => $memory));
echo Yii::t('YupeModule.yupe', ' run in: {time}', array('{time}' => $time));
echo "</div>";
