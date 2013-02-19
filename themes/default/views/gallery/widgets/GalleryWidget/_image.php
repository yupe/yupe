<?php
echo CHtml::link(CHtml::image(
            $data->image->getUrl(),
            $data->image->alt,
            array('width' => 300)
        ),
        $data->image->getUrl(), array('class' => 'fancybox', 'title' => $data->image->name, 'rel' => 'gallery1')
    );
?>


