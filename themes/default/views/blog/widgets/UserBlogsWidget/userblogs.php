<?php if (!empty($models)): ?>
    <?= Yii::t('BlogModule.blog', 'Member of :'); ?>
    <div>
        <?php foreach ($models as $model): ?>
            <?= CHtml::link(
                CHtml::encode($model->name),
                ['/blog/blog/show', 'slug' => CHtml::encode($model->slug)]
            ); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
