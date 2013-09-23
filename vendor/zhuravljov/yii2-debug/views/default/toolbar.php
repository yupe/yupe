<?php
/**
 * @var DefaultController $this
 * @var Yii2DebugPanel[] $panels
 * @var string $tag
 */

$url = $panels['request']->getUrl();
?>
<div id="yii2-debug-toolbar">
	<?php foreach ($panels as $panel): ?>
	<?php echo $panel->getSummary(); ?>
	<?php endforeach; ?>
	<span class="yii2-debug-toolbar-toggler">›</span>
</div>
<div id="yii2-debug-toolbar-min">
	<a href="<?php echo $url; ?>" title="Open Yii Debugger" id="yii2-debug-toolbar-logo">
		<img width="29" height="30" alt="" src="<?php echo Yii2ConfigPanel::getYiiLogo(); ?>">
	</a>
	<span class="yii2-debug-toolbar-toggler">‹</span>
</div>

<style type="text/css">
<?php echo file_get_contents(dirname(__FILE__) . '/toolbar.css'); ?>
</style>