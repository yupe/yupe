<ul class="yii-debug-toolbar-tabs">
    <li class="active" type="yii-debug-toolbar-sql-summary"><a href="javascript:;//">
        <?php echo Yii::t('yii-debug-toolbar','Summary')?></a></li>
    <li type="yii-debug-toolbar-sql-callstack"><a href="javascript:;//">
        <?php echo Yii::t('yii-debug-toolbar','Callstack')?></a></li>
    <li type="yii-debug-toolbar-sql-servers"><a href="javascript:;//">
        <?php echo Yii::t('yii-debug-toolbar','Servers')?></a></li>
</ul>

<?php $this->render('sql/servers', array(
    'connections'=>$connections
)) ?>

<?php $this->render('sql/summary', array(
    'summary'=>$summary
)) ?>

<?php $this->render('sql/callstack', array(
    'callstack'=>$callstack
)) ?>
