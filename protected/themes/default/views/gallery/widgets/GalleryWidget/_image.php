<div class="span-5 image">
<?php
    echo CHtml::link(CHtml::image($data->image->getUrl(), $data->image->alt),
    	$data->image->getUrl(), array('class' => 'fancybox', 'title' => $data->image->description, 'rel' => $data->gallery->id)
	);
?>
</div>