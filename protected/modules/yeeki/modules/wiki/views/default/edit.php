<h1><?php echo CHtml::encode($page->getWikiUid())?></h1>

<?php echo CHtml::beginForm('', 'post', array('id' => 'edit-page-form'))?>
<div>
<?php echo CHtml::activeTextArea($page, 'content')?>
</div>
<div>
	<?php echo CHtml::label(Yii::t('wiki', 'Change summary'), CHtml::getIdByName('comment'))?>: <?php echo CHtml::textField('comment', $comment)?>
</div>
<div>
<?php echo CHtml::submitButton(Yii::t('wiki', 'Save'))?>
</div>
<?php echo CHtml::endForm()?>