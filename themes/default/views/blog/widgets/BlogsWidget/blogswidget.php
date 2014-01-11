<div class="yupe-widget-header">
    <i class="icon-pencil"></i>
    <h3><?php echo Yii::t('BlogModule.blog','Blogs');?></h3>
</div>

<div class="yupe-widget-content">
	<ul class="unstyled">
	    <?php $cnt = count($models); $i = 0; ?>
	    <?php foreach ($models as $model): ?>
	        <li>
	            <p>
	                <?php echo CHtml::link($model->name, array('/blog/blog/show/', 'slug' => $model->slug)); ?>
	                &rarr;
	                <i class="icon-user"></i>
	                <?php echo $model->membersCount; ?>
	                &rarr;
	                <i class="icon-file-alt"></i>
	                <?php echo CHtml::link($model->postsCount,array('/blog/post/blog/','slug' => $model->slug)); ?>
	            </p>
	        </li>
	        <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
	    <?php endforeach; ?>
	</ul>
</div>	
