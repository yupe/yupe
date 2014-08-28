<?php if (!empty($models)): ?>
    <?php echo Yii::t('BlogModule.blog', 'Member of :'); ?>
    <div>
        <?php foreach ($models as $model): ?>
            <?php echo CHtml::link(
                CHtml::encode($model->name),
                array('/blog/blog/show', 'slug' => CHtml::encode($model->slug))
            ); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
