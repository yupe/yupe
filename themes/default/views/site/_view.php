<div class="row">
    <div class="span8">
        <h4><strong><?php echo CHtml::link(
                    CHtml::encode($data->title),
                    ['/blog/post/show/', 'slug' => $data->slug]
                ); ?></strong></h4>
    </div>
</div>
<div class="row">
    <div class="span8">
        <p> <?php echo $data->getQuote(); ?></p>
        <!--<p><?php echo CHtml::link(
            Yii::t('default', 'read...'),
            ['/blog/post/show/', 'slug' => $data->slug],
            ['class' => 'btn']
        ); ?></p>-->
    </div>
</div>

<?php $this->widget('blog.widgets.PostMetaWidget', ['post' => $data]); ?>

<hr>
