<?php
/* @var Yii2DbPanel $this */
/* @var int $count */
/* @var string $time */
?>
<div class="yii2-debug-toolbar-block">
	<a href="<?= $this->getUrl() ?>" title="Executed <?= $count ?> database queries which took <?= $time ?>.">
		DB
		<span class="label"><?= $count ?></span>
		<span class="label"><?= $time ?></span>
	</a>
</div>
