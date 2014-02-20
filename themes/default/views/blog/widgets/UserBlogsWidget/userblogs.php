<?php if(!empty($models)):?>
	<?php echo Yii::t('BlogModule.blog','Member of :');?>
	<div>
		<?php foreach($models as $model):?>
			<?php echo CHtml::link($model->name, array('/blog/blog/show','slug' => $model->slug));?>
		<?php endforeach;?>	
	</div>
<?php endif;?>	