<?php echo CHtml::openTag('div', $layoutParams['htmlOptions']); ?>
    <?php echo $this->widget('zii.widgets.CMenu', $params, true); ?>
<?php echo CHtml::closeTag('div'); ?>