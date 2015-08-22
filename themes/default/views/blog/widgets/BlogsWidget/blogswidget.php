<?php
$this->beginWidget(
    'bootstrap.widgets.TbPanel',
    [
        'title'      => Yii::t('BlogModule.blog', 'Blogs'),
        'headerIcon' => 'glyphicon glyphicon-pencil',
    ]
);
?>
<ul class="list-unstyled">
    <?php foreach ($models as $model): ?>
        <li>
            <p>
                <?= CHtml::link(
                    CHtml::encode($model->name),
                    ['/blog/blog/view/', 'slug' => CHtml::encode($model->slug)]
                ); ?>
                &rarr;
                <i class="glyphicon glyphicon-user"></i>
                <?= CHtml::link(
                    $model->membersCount,
                    ['/blog/blog/members', 'slug' => CHtml::encode($model->slug)]
                ); ?>
                &rarr;
                <i class="glyphicon glyphicon-file"></i>
                <?= CHtml::link(
                    $model->postsCount,
                    ['/blog/post/blog/', 'slug' => CHtml::encode($model->slug)]
                ); ?>
            </p>
        </li>
        <hr/>
    <?php endforeach; ?>
</ul>
<?php $this->endWidget(); ?>
