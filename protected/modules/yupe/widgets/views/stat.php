<?php
echo '<div class="stat" id="stat">';
if (Yii::app()->db->enableParamLogging == true || Yii::app()->db->enableProfiling == true) {
    echo Yii::t('YupeModule.yupe', 'requests: {qcount}', ['{qcount}' => $dbStat[0]]);
    echo Yii::t('YupeModule.yupe', ' time: {qtime}', ['{qtime}' => round($dbStat[1], 3)]);
}
echo "<div>";
echo Yii::t('YupeModule.yupe', 'memory: {memory}', ['{memory}' => $memory]);
echo Yii::t('YupeModule.yupe', ' run in: {time}', ['{time}' => $time]);
echo "</div>";
