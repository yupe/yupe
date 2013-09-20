<?php $this->breadcrumbs = array(
     Yii::t('WikiModule.wiki', 'Wiki') => array('/wiki/default/pageIndex'),
     Yii::t('WikiModule.wiki', 'Edit')
);?>

<h1><?php echo CHtml::encode($page->getWikiUid())?></h1>

<?php echo CHtml::beginForm('', 'post', array('id' => 'edit-page-form'))?>
<div>
<?php echo CHtml::activeTextArea($page, 'content')?>
</div>
<div>
	<?php echo CHtml::label(Yii::t('WikiModule.wiki', 'Change summary'), CHtml::getIdByName('comment'))?>: <?php echo CHtml::textField('comment', $comment)?>
</div>
<div>
<?php echo CHtml::submitButton(Yii::t('WikiModule.wiki', 'Save'))?>
</div>
<?php echo CHtml::endForm()?>