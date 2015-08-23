<?php if (!empty($models)): ?>
    <?= Yii::t('BlogModule.blog', 'Member of :'); ?>
    <div>
        <?php foreach ($models as $model): ?>
            <?= CHtml::link(
                CHtml::encode($model->name),
                ['/blog/blog/view', 'slug' => CHtml::encode($model->slug)],
                ['class' => 'label label-info']
            ); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
