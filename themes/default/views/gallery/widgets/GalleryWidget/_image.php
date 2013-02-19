<div class="image <?php echo $data->id; ?>">
<?php
    echo CHtml::link(CHtml::image($data->image->getUrl(), $data->image->alt, array('width' => 300)),
    $data->image->getUrl(), array('class' => 'fancybox', 'title' => $data->image->name, 'rel' => $data->gallery->id)
);
?>
</div>


