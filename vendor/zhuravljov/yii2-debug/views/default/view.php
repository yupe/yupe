<?php
/**
 * @var DefaultController $this
 * @var array $summary
 * @var string $tag
 * @var array $manifest
 * @var Yii2DebugPanel[] $panels
 * @var Yii2DebugPanel $activePanel
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
			<div class="span2">
				<ul class="nav nav-pills nav-stacked">
					<?php
					foreach ($panels as $id => $panel) {
						$link = CHtml::link(CHtml::encode($panel->getName()), array('view', 'tag' => $tag, 'panel' => $id));
						echo CHtml::tag('li', array('class' => $panel === $activePanel ? 'active' : null), $link);
					}
					?>
				</ul>
			</div><!--/span-->
			<div class="span10">
				<div class="callout alert alert-info">
					<div class="btn-group">
						<?php echo CHtml::link('All', array('index'), array('class' => 'btn')); ?>
						<button class="btn dropdown-toggle" data-toggle="dropdown">
							Last 10
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<?php
							$count = 0;
							foreach ($manifest as $meta) {
								$label = $meta['method'] . ' ' . $meta['url'] . ($meta['ajax'] ? ' (AJAX)' : '')
									. ', ' . date('Y-m-d h:i:s', $meta['time'])
									. ', ' . $meta['ip'];
								$url = array('view', 'tag' => $meta['tag'], 'panel' => $activePanel->id);
								if ($meta['tag'] == $tag && $count > 0) {
									echo '<li class="divider"></li>';
								}
								echo '<li>';
								echo CHtml::link(CHtml::encode($label), $url);
								echo '</li>';
								if (++$count >= 10) {
									break;
								}
								if ($meta['tag'] == $tag) {
									echo '<li class="divider"></li>';
								}
							}
							?>
						</ul>
					</div>
					<?php echo $summary['method']; ?>
					<?php echo CHtml::link(CHtml::encode($summary['url']), $summary['url']); ?>
					<?php echo $summary['ajax'] ? ' (AJAX)' : ''; ?>
					at <?php echo date('Y-m-d h:i:s', $summary['time']); ?>
					by <?php echo $summary['ip']; ?>
				</div>
				<?php echo $activePanel->getDetail(); ?>
			</div>
		</div>
	</div>
</div>
