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
            <?php echo CHtml::link($tag['name'], ['/blog/post/list/', 'tag' => $tag['name']]); ?>
        </div>
        <div class="col-sm-6">
            <span class="badge pull-right"><?php echo $tag['count']; ?></span>
        </div>
    </div>
<?php endforeach; ?>

<?php $this->endWidget(); ?>
