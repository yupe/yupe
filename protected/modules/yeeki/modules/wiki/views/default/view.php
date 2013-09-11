<?php $this->breadcrumbs = array(
     Yii::t('WikiModule.wiki', 'Wiki') => array('/wiki/default/pageIndex'),
     Yii::t('WikiModule.wiki', $page->getWikiUid())
);?>


<div>
	<div class="wiki-controls">
		<?php echo CHtml::link(Yii::t('WikiModule.wiki', 'Edit'), array('edit', 'uid' => $page->getWikiUid()))?>
		<?php echo CHtml::link(Yii::t('WikiModule.wiki', 'History'), array('history', 'uid' => $page->getWikiUid()))?>
	</div>
	<div class="wiki-text">
		<?php echo $text?>
	</div>	
	<div class="wiki-controls">
		<?php echo CHtml::link(Yii::t('WikiModule.wiki', 'Edit'), array('edit', 'uid' => $page->getWikiUid()))?>
		<?php echo CHtml::link(Yii::t('WikiModule.wiki', 'History'), array('history', 'uid' => $page->getWikiUid()))?>
		<?php echo CHtml::link(Yii::t('WikiModule.wiki', 'Page Index'), array('pageIndex'))?>
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