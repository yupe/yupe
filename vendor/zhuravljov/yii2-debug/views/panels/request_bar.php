<?php
/* @var Yii2RequestPanel $this */
?>
<?php if ($statusCode = $this->data['statusCode']): ?>
	<div class="yii2-debug-toolbar-block">
		<a href="<?= $this->getUrl() ?>" title="Status code: <?= $statusCode ?>">
			Status
			<?php if ($statusCode >= 200 && $statusCode < 300): ?>
				<span class="label label-success"><?= $statusCode ?></span>
			<?php elseif ($statusCode >= 100 && $statusCode < 200): ?>
				<span class="label label-info"><?= $statusCode ?></span>
			<?php else: ?>
				<span class="label label-important"><?= $statusCode ?></span>
			<?php endif; ?>
		</a>
	</div>
<?php endif; ?>
<div class="yii2-debug-toolbar-block">
	<a href="<?= $this->getUrl() ?>" title="Route: <?= $this->data['route'] ?>">
		Action <span class="label"><?= $this->data['action'] ?></span>
	</a>
</div>
