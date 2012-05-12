<h1><?php echo CHtml::link(CHtml::encode($page->getWikiUid()), array('view', 'uid' => $page->getWikiUid()))?> <?php echo Yii::t('wiki', 'version history')?></h1>

<?php echo CHtml::beginForm()?>
<table>
	<tr>
		<th></th>
		<th>Revision</th>
		<th>Created at</th>
		<th>Comment</th>
	</tr>
	<?php foreach($revisions as $revision):?>
	<tr>
		<td><?php echo CHtml::checkBox('r'.$revision->id)?></td>
		<td><?php echo CHtml::link('r'.$revision->id, array('view', 'uid' => $page->page_uid, 'rev' => $revision->id))?></td>
		<td><?php echo Yii::app()->format->formatDatetime($revision->created_at)?></td>
		<td><?php echo CHtml::encode($revision->comment)?></td>
	</tr>
	<?php endforeach ?>
</table>
<div>
	<?php echo CHtml::submitButton(Yii::t('wiki', 'Show diff'))?>
</div>
<?php echo CHtml::endForm()?>