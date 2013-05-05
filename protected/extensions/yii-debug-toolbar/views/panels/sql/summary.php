<?php if (!empty($summary)) :?>
<table id="yii-debug-toolbar-sql-summary" class="tabscontent">
    <thead>
        <tr>
            <th><?php echo Yii::t('yii-debug-toolbar','Query')?></th>
            <th nowrap="nowrap"><?php echo Yii::t('yii-debug-toolbar','Count')?></th>
            <th nowrap="nowrap"><?php echo Yii::t('yii-debug-toolbar','Total (s)')?></th>
            <th nowrap="nowrap"><?php echo Yii::t('yii-debug-toolbar','Avg. (s)')?></th>
            <th nowrap="nowrap"><?php echo Yii::t('yii-debug-toolbar','Min. (s)')?></th>
            <th nowrap="nowrap"><?php echo Yii::t('yii-debug-toolbar','Max. (s)')?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($summary as $id=>$entry):?>
        <tr class="<?php echo ($id%2?'odd':'even') ?><?php echo ($entry[1]>$this->countLimit || ($entry[4]/$entry[1] > $this->timeLimit) ?' warning':'') ?>">
            <td width="100%"><?php echo $entry[0]; ?></td>
            <td nowrap="nowrap" style="text-align: center;"><?php echo number_format($entry[1]); ?></td>
            <td nowrap="nowrap"><?php echo sprintf('%0.6F',$entry[4]); ?></td>
            <td nowrap="nowrap"><?php echo sprintf('%0.6F',$entry[4]/$entry[1]); ?></td>
            <td nowrap="nowrap"><?php echo sprintf('%0.6F',$entry[2]); ?></td>
            <td nowrap="nowrap"><?php echo sprintf('%0.6F',$entry[3]);?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else : ?>
<p id="yii-debug-toolbar-sql-summary" class="tabscontent">
    <?php echo Yii::t('yii-debug-toolbar','No SQL queries were recorded during this request or profiling the SQL is DISABLED.')?>
</p>
<?php endif; ?>