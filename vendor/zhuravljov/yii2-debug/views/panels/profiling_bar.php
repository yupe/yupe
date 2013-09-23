<?php
/* @var Yii2ProfilingPanel $this */
/* @var string $time */
/* @var string $memory */
?>
<div class="yii2-debug-toolbar-block">
	<a href="<?= $this->getUrl() ?>" title="Total request processing time was <?= $time ?>">
		Time <span class="label"><?= $time ?></span>
	</a>
</div>
<div class="yii2-debug-toolbar-block">
	<a href="<?= $this->getUrl() ?>" title="Peak memory consumption was <?= $memory ?>">
		Memory <span class="label"><?= $memory ?></span>
	</a>
</div>
