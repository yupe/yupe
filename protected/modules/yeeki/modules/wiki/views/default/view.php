<div>
	<div class="wiki-controls">
		<?php echo CHtml::link(Yii::t('wiki', 'Edit'), array('edit', 'uid' => $page->getWikiUid()))?>
		<?php echo CHtml::link(Yii::t('wiki', 'History'), array('history', 'uid' => $page->getWikiUid()))?>
	</div>
	<div class="wiki-text">
		<?php echo $text?>
	</div>	
	<div class="wiki-controls">
		<?php echo CHtml::link(Yii::t('wiki', 'Edit'), array('edit', 'uid' => $page->getWikiUid()))?>
		<?php echo CHtml::link(Yii::t('wiki', 'History'), array('history', 'uid' => $page->getWikiUid()))?>
		<?php echo CHtml::link(Yii::t('wiki', 'Page Index'), array('pageIndex'))?>
	</div>	
</div>
<br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array(
  'model' => $page,
  'modelId' => $page->id
)); ?>

<br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'redirectTo' => $this->createUrl('/wiki/default/view/', array('uid' => $page->page_uid)),
    'model'   => $page,
    'modelId' => $page->id,
)); ?>