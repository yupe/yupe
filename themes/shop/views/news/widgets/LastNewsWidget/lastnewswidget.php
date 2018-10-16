<?php Yii::import('application.modules.news.NewsModule'); ?>
<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'><?= Yii::t('NewsModule.news', 'News'); ?></div>
    </div>
    <div class='portlet-content'>
        <?php if (isset($models) && $models != []): ?>
            <ul>
                <?php foreach ($models as $model): ?>
                    <li><?= CHtml::link(
                            $model->title,
                            ['/news/news/view/', 'slug' => $model->slug]
                        ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
