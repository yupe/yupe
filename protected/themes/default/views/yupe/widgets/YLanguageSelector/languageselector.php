<?php $i = 1; ?>
<div style="font-size: 11px">
    <?php foreach($langs as $lang): ?>
        <?php
        $i++;
        $icon = ($this->enableFlag) ? '<i class="iconflags iconflags-' . $lang . '"></i>' : '';
        ?>
        <?php if ($currentLanguage == $lang): ?>
            <span><?php echo $icon . strtoupper(Yii::t('yupe', $lang)); ?></span>
        <?php else:?>
            <?php echo CHtml::link($icon . strtoupper(Yii::t('yupe', $lang)), $homeUrl . Yii::app()->urlManager->replaceLangUrl($cleanUrl, $lang));?>
        <?php endif?>
        <?php if ($i == count($langs)): ?>|<?php endif; ?>
    <?php endforeach;?>
</div>