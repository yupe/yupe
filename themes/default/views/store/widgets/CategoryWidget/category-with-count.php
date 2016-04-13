<h4><?= Yii::t('StoreModule.store', 'Categories') ?></h4>

<ul class="list-unstyled">
    <?php foreach ($tree as $item): ?>
        <li>
            <?= CHtml::link($item['label'], $item['url']) ?>
            <span class="label label-info"><?= $item['count'] ?></span>
        </li>
    <?php endforeach; ?>
</ul>