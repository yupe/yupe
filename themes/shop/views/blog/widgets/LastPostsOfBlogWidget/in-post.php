<?php Yii::import('application.modules.blog.BlogModule'); ?>

<h4><?= Yii::t('BlogModule.blog', 'Last blog posts'); ?>:</h4>
<div>
    <ul class="list-unstyled">
        <?php foreach ($posts as $data): ?>
            <li><?= CHtml::link(
                    CHtml::encode($data->title),
                    $data->getUrl()
                ); ?></li>
        <?php endforeach ?>
    </ul>
</div>
