<?php
$allPanelID = array();
?>

<div id="yii-debug-toolbar-swither">
    <a href="javascript:;//"><?php echo YiiDebug::t('TOOLBAR')?></a>
</div>
<div id="yii-debug-toolbar" style="display:none;">
    <div id="yii-debug-toolbar-buttons">
        <ul>
            <li><br />&nbsp;<br /></li>
            <?php foreach ($panels as $panel) :
                array_push($allPanelID, $panel->id);
            ?>
            <li class="yii-debug-toolbar-button <?php echo $panel->id ?>">
                <a class="yii-debug-toolbar-link" href="#<?php echo $panel->id ?>" id="yii-debug-toolbar-tab-<?php echo $panel->id ?>">
                    <?php echo CHtml::encode($panel->menuTitle); ?>
                    <?php if (!empty($panel->menuSubTitle)): ?>
                    <br />
                    <small><?php echo $panel->menuSubTitle; ?></small>
                    <?php endif; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div id="resource-usage">
                <?php $this->widget('YiiDebugToolbarResourceUsage', array(
                    'title'=>'Resource usage',
                    'htmlOptions'=>array(
                        'class'=>'panel'
                    )
                )); ?>
        </div>
    </div>

    <?php foreach ($panels as $panel) : ?>
    <div id="<?php echo $panel->id ?>" class="yii-debug-toolbar-panel">
        <div class="yii-debug-toolbar-panel-title">
        <a href="#close" class="yii-debug-toolbar-panel-close"><?php echo YiiDebug::t('Close')?></a>
        <h3>
            <?php echo CHtml::encode($panel->title); ?>
            <?php if ($panel->subTitle) : ?>
            <small><?php echo CHtml::encode($panel->subTitle); ?></small>
            <?php endif; ?>
        </h3>
        </div>
        <div class="yii-debug-toolbar-panel-content">
            <div class="scroll">
                <div class="scrollcontent">
                <?php $panel->run(); ?>
                <br />
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script type="text/javascript">

    var $allPanelID = <?php echo CJavaScript::encode($allPanelID); ?>;
    var hash = '';

(function($) {
    $(function(){
        yiiDebugToolbar.init();

        <?php if($this->owner->openLastPanel){ ?>
        hash = location.hash.replace('#','');
        if($allPanelID.indexOf(hash) != -1){
            $('#yii-debug-toolbar-tab-'+hash).trigger('click');
        }
        <?php } ?>
    });
}(jQuery));
</script>
