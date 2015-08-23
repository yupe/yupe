<?php
$this->beginWidget(
    'bootstrap.widgets.TbPanel',
    [
        'title' => Yii::t('YupeModule.yupe', 'Tags cloud'),
    ]
);
?>
<?php foreach ($tags as $tag): ?>
    <div class="row">
        <div class="col-sm-6">
            <?= CHtml::link($tag['name'], ['/blog/post/tag/', 'tag' => $tag['name']]); ?>
        </div>
        <div class="col-sm-6">
            <span class="badge pull-right"><?= $tag['count']; ?></span>
        </div>
    </div>
<?php endforeach; ?>

<?php $this->endWidget(); ?>
