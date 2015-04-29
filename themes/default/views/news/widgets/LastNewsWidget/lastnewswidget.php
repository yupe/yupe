<?php Yii::import('application.modules.news.NewsModule'); ?>
<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'><?php echo Yii::t('NewsModule.news', 'News'); ?></div>
    </div>
    <div class='portlet-content'>
        <?php if (isset($models) && $models != []): ?>
            <ul>
                <?php foreach ($models as $model): ?>
                    <li><?php echo CHtml::link(
                            $model->title,
                            ['/news/news/show/', 'slug' => $model->slug]
                        ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
