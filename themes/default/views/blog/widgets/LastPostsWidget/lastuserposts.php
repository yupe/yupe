<?php if(!empty($models)):?>
<br/><br/>
<div>
    <?php echo Yii::t('BlogModule.blog','Latest posts');?>:    
	<ul class="unstyled">	    
	    <?php foreach ($models as $model): ?>
	        <li>
	            <?php echo CHtml::link($model->title, array('/blog/post/show/', 'slug' => $model->slug)); ?>	          
                <nobr>
                    <i class="icon-comment-alt"></i>
                    <?php echo $model->getCommentCount(); ?>
                </nobr>	   
                <hr/>         
	        </li>	        
	    <?php endforeach; ?>
	</ul>
</div>
<?php endif;?>