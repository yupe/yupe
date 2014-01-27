<?php if(!empty($models)):?>
	<?php echo Yii::t('BlogModule.blog','Member of :');?>
	<div>
		<?php foreach($models as $model):?>
			<?php echo CHtml::link($model->blog->name, array('/blog/post/show','slug' => $model->blog->slug));?>
		<?php endforeach;?>	
	</div>
<?php endif;?>	