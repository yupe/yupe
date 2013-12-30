<ul class="unstyled">
    <?php $cnt = count($models); $i = 0; ?>
    <?php foreach ($models as $model): ?>
        <li>
            <?php echo CHtml::link($model->title, array('/blog/post/show/', 'slug' => $model->slug)); ?>
            <?php if ($model->comment_status == 1 && $model->commentsCount): ?>
                <nobr>
                    <i class="icon-comment-alt"></i>
                    <?php echo ($model->commentsCount>0) ? $model->commentsCount-1 : 0; ?>
                </nobr>
            <?php endif; ?>
        </li>
        <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
    <?php endforeach; ?>
</ul>