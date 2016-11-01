<?php
/* @var $currentLanguage string */
/* @var $currentUrl string */
/* @var $langs array */
/* @var $urlManager \yupe\components\urlManager\LangUrlManager */
$urlManager = Yii::app()->getUrlManager();
?>

<?php $i = 1; ?>

<div style="font-size: 11px">
    <?php foreach ($langs as $lang): ?>

        <?php
        $i++;
        $icon = ($this->enableFlag) ? '<i class="iconflags iconflags-' . $lang . '"></i>' : '';
        ?>

        <?php if ($currentLanguage == $lang): ?>
            <span><?= $icon . strtoupper(Yii::t('default', $lang)); ?></span>
        <?php else: ?>
            <?= CHtml::link(
                $icon . strtoupper(Yii::t('default', $lang)),
                $urlManager->replaceLangInUrl($currentUrl, $lang)
            ); ?>
        <?php endif ?>

        <?php if ($i == count($langs)): ?>|<?php endif; ?>

    <?php endforeach; ?>
</div>
