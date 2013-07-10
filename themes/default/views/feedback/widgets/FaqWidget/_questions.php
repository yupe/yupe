<div class="faq-widget">
    <ul class="unstyled">
        <?php $cnt = count($models); $i = 0; ?>
        <?php foreach ($models as $model): ?>
            <li>
                <?php echo CHtml::link(YText::characterLimiter($model->text,50), array('/feedback/contact/faqView/', 'id' => $model->id)); ?>
                <?php if ($model->commentsCount): ?>
                    <nobr>
                        <i class="icon-comment-alt"></i>
                        <?php echo $model->commentsCount; ?>
                    </nobr>
                <?php endif; ?>
            </li>
            <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
        <?php endforeach;?>
    </ul>
</div>