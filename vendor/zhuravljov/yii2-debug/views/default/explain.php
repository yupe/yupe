<?php
/**
 * @var DefaultController $this
 * @var array $summary
 * @var string $tag
 * @var array $manifest
 * @var Yii2DebugPanel[] $panels
 * @var Yii2DbPanel $dbPanel
 * @var CDbConnection $connection
 * @var string $procedure
 * @var array $explainRows
 */

$this->pageTitle = 'Yii Debugger';
?>
<div class="default-view">
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<div class="yii2-debug-toolbar-block title">
					Yii Debugger
				</div>
				<?php foreach ($panels as $panel): ?>
					<?php echo $panel->getSummary(); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<h1>Explain Query (<?= $connection->driverName ?>)</h1>
				<div class="well">
					<?= $dbPanel->highlightCode ?
						$dbPanel->highlightSql($procedure) :
						CHtml::encode($procedure)
					?>
				</div>
				<?php $this->renderPartial('_explain', array(
					'connection' => $connection,
					'explainRows' => $explainRows,
				)); ?>
			</div><!--/span-->
		</div>
	</div>
</div>
