<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Блоги</div>
    </div>
    <div class='portlet-content'>
        <?php if (isset($models) && $models != array()): ?>
            <ul>
                <?php foreach ($models as $model): ?>
                    <li><?php echo CHtml::link($model->name, array('/blog/blog/show/', 'slug' => $model->slug)); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
