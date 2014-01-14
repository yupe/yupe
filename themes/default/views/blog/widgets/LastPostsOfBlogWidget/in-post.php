<?php Yii::import('application.modules.blog.BlogModule'); ?>

<h4><?php echo Yii::t('BlogModule.blog','Last blog posts'); ?>:</h4>
<div>
    <ul class="unstyled">
		<?php foreach($posts as $data):?>  		  
		     <li><?php echo CHtml::link(CHtml::encode($data->title), array('/blog/post/show/', 'slug' => $data->slug)); ?></li>	  
		<?php endforeach?>
	</ul>     
</div> 