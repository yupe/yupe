<?php $this->breadcrumbs = array(
    Yii::t('WikiModule.wiki', 'Wiki') => array('/wiki/default/pageIndex'),
);?>
<?php echo Yii::t('WikiModule.wiki', 'There is no page yet.')?>
<?php echo CHtml::link(Yii::t('WikiModule.wiki', 'Create'), array('edit', 'uid' => $uid))?>?