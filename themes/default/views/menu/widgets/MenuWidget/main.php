<?php echo CHtml::openTag('div', $layoutParams['htmlOptions']); ?>
    <?php echo $this->widget('zii.widgets.CMenu', $params, true); ?>
    <br style="clear: left"/>
<?php echo CHtml::closeTag('div'); ?>
