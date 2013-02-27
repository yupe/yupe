<?php $this->widget('gallery.extensions.fancybox.FancyBox', array(
    'target' => '.fancybox',
    'config' => array(
        'helpers' => array('title' => array('type' => 'inside'))
    ),
)); ?>


    <?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_image',
)); ?>
