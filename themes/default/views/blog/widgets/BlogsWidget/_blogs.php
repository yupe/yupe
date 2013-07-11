<div class="blogs-widget">
    <ul class="unstyled">
        <?php $cnt = count($models); $i = 0; ?>
        <?php foreach ($models as $model): ?>
            <li>
                <p>
                    <?php echo CHtml::link($model->name, array('/blog/blog/show/', 'slug' => $model->slug)); ?>
                </p>
                <p>
                    <i class="icon-user"></i>
                    Участников:
                    <?php echo $model->membersCount; ?>

                    <i class="icon-file-alt"></i>
                    Записей:
                    <?php echo $model->postsCount; ?>
                </p>
            </li>
            <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
        <?php endforeach; ?>
    </ul>
</div>
