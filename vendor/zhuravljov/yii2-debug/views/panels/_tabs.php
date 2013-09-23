<?php
/* @var Yii2DebugPanel $this */
/* @var string $id */
/* @var array $items */
?>
<ul id="<?= $id ?>" class="nav nav-tabs">
<?php foreach ($items as $num => $item): ?>
	<li class="<?= isset($item['active']) && $item['active'] ? 'active' : '' ?>">
		<a href="<?= "#$id-tab$num" ?>" data-toggle="tab">
			<?= CHtml::encode($item['label']) ?>
		</a>
	</li>
<?php endforeach; ?>
</ul>
<div class="tab-content">
<?php foreach ($items as $num => $item): ?>
	<div id="<?= "$id-tab$num" ?>" class="tab-pane<?= isset($item['active']) && $item['active'] ? ' active' : '' ?>">
		<?= $item['content'] ?>
	</div>
<?php endforeach; ?>
</div>