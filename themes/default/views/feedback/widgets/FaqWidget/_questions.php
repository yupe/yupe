<ul class="list-unstyled">
    <?php $cnt = count($models);
    $i = 0; ?>
    <?php foreach ($models as $model): ?>
        <li>
            <?= CHtml::link(
                yupe\helpers\YText::characterLimiter($model->text, 50),
                ['/feedback/contact/faqView/', 'id' => $model->id]
            ); ?>
        </li>
        <?php $i++;
        if ($i != $cnt) {
            echo '<hr>';
        } ?>
    <?php endforeach; ?>
</ul>
