<?php $currentLanguage = Yii::app()->language; ?>
<?php $cp = Yii::app()->urlManager->getCleanUrl(Yii::app()->request->url); ?>
<?php $i = 1; ?>
<?php $langs = explode(',', Yii::app()->getModule('yupe')->availableLanguages); ?>
<div style="font-size: 11px">
    <?php foreach($langs as $lang): ?>
        <?php $i++; ?>
        <?php if($currentLanguage == $lang): ?>
            <span><?php echo strtoupper($lang); ?></span>
        <?php else:?>
            <?php echo CHtml::link(strtoupper($lang), Yii::app()->homeUrl . '/' . Yii::app()->urlManager->replaceLangUrl($cp, $lang));?>
        <?php endif?>
            <?php if($i == count($langs)): ?>|<?php endif; ?>
    <?php endforeach;?>
</div>