<?php Yii::import('application.modules.news.NewsModule'); ?>
<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'><?php echo Yii::t('NewsModule.news', 'News'); ?></div>
    </div>
    <div class='portlet-content'>
        <?php if (isset($models) && $models != array()): ?>
            <ul>
                <?php foreach ($models as $model): ?>
                    <li><?php echo CHtml::link(
                            $model->title,
                            array('/news/news/show/', 'alias' => $model->alias)
                        ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
