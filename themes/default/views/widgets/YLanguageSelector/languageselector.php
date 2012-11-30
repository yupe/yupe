<?php $currentLanguage = Yii::app()->language; ?>
<?php $cp = Yii::app()->urlManager->getCleanUrl(Yii::app()->request->url); ?>
<?php $i = 1; ?>
<?php $langs = explode(',', $this->controller->yupe->availableLanguages); ?>
<div style="font-size: 11px">
    <?php if(count($langs) > 1):?>
    <?php foreach($langs as $lang): ?>
        <?php $i++; ?>
        <?php if($currentLanguage == $lang): ?>
            <span><?php echo strtoupper($lang); ?></span>
        <?php else:?>
            <?php echo CHtml::link(strtoupper($lang), Yii::app()->homeUrl . '/' . Yii::app()->urlManager->replaceLangUrl($cp, $lang));?>
        <?php endif?>
            <?php if($i == count($langs)): ?>|<?php endif; ?>
    <?php endforeach;?>
    <?php endif;?>
</div>