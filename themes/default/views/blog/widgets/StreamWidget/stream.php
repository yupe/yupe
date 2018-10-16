<?php
$this->beginWidget(
    'bootstrap.widgets.TbPanel',
    [
        'title'      => Yii::t('BlogModule.blog', 'Discuss'),
        'headerIcon' => 'glyphicon glyphicon-pencil',
    ]
);
?>
<ul class="list-unstyled">
    <?php foreach ($data as $model): ?>
        <li>
            <?= CHtml::link(
                CHtml::encode($model['title']),
                ['/blog/post/view/', 'slug' => CHtml::encode($model['slug'])]
            ); ?>
            <i class="glyphicon glyphicon-comment"></i>
            <?= $model['commentsCount']; ?>
        </li>
        <hr>
    <?php endforeach; ?>
</ul>
<?php $this->endWidget(); ?>
