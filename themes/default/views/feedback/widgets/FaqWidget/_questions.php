<ul class="unstyled">
    <?php $cnt = count($models); $i = 0; ?>
    <?php foreach ($models as $model): ?>
        <li>
            <?php echo CHtml::link(yupe\helpers\YText::characterLimiter($model->text,50), array('/feedback/contact/faqView/', 'id' => $model->id)); ?>
        </li>
        <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
    <?php endforeach;?>
</ul>