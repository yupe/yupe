<?php
$this->breadcrumbs = [
    Yii::t('YupeModule.yupe', 'Yupe!') => ['settings'],
    Yii::t('YupeModule.yupe', 'Modules'),
];

$script = "var url = document.location.toString();
    if (url.match('#')) { $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show'); }
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        if(history.pushState) { history.pushState(null, null, e.target.hash); } else { window.location.hash = e.target.hash; }
    });";

Yii::app()->getClientScript()->registerScript('tabs-remember', $script, CClientScript::POS_END);
?>

<h1><?= Yii::t('YupeModule.yupe', 'Modules'); ?></h1>

<?= Yii::t(
    'YupeModule.yupe',
    'Setup modules "{app}" for your needs',
    ['{app}' => CHtml::encode(Yii::app()->name)]
); ?>

<br/><br/>
<div class="alert alert-warning">
    <p>
        <?php
        $yupeCount = count($modules);
        $enableCount = 0;
        foreach ($modules as $module) {
            if ('install' === $module->id) {
                $enableCount--;
                $yupeCount--;
            }
            if ($module instanceof yupe\components\WebModule && ($module->getIsActive() || $module->getIsNoDisable())) {
                $enableCount++;
            }
        }
        ?>
        <?= Yii::t('YupeModule.yupe', 'Installed'); ?>
        <small class="label label-info"><?= $yupeCount; ?></small>
        <?= Yii::t('YupeModule.yupe', 'module|module|modules', $yupeCount); ?>,
        <?= Yii::t('YupeModule.yupe', 'enabled'); ?>
        <small class="label label-info"><?= $enableCount; ?></small>
        <?= Yii::t('YupeModule.yupe', 'module|module|modules', $enableCount); ?>,
        <?= Yii::t('YupeModule.yupe', 'disabled|disabled', $yupeCount - $enableCount); ?>
        <small class="label label-info"><?= $yupeCount - $enableCount; ?></small>
        <?= Yii::t('YupeModule.yupe', 'module|module|modules', $yupeCount - $enableCount); ?>
        <br/>
    </p>
</div>

<?= $this->renderPartial('_moduleslist', ['modules' => $modules]); ?>
