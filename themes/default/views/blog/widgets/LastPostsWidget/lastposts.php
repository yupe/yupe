<div class="yupe-widget-header">
     <h3><?php echo Yii::t('BlogModule.blog','Latest posts');?></h3>
</div>
<div class="yupe-widget-content" id="latest-posts-widget">
	<ul class="unstyled">	    
	    <?php foreach ($models as $model): ?>
	        <li>
	            <?php echo CHtml::link(CHtml::encode($model->title), array('/blog/post/show/', 'slug' => CHtml::encode($model->slug))); ?>
                <nobr>
                    <i class="fa icon-comment"></i>
                    <?php echo $model->getCommentCount(); ?>
                </nobr>	 
	            <hr/>
	        </li>	        
	    <?php endforeach; ?>
	</ul>
</div>