<div class="catalog__category-item">
    <?php if ($data['icon']): ?>
        <a href="<?= $data['url']; ?>">
            <img src="<?= $data['icon']; ?>" alt="<?= $data['icon_alt']; ?>" title="<?= $data['icon_title']; ?>"/>
        </a>
    <?php endif; ?>
    <a href="<?= $data['url']; ?>" class="catalog__category-item-title"><?= CHtml::encode($data['label']); ?></a>
    <?php if ($data['items']): ?>
        <ul>
            <?php foreach ($data['items'] as $item): ?>
                <li><a href="<?= $item['url'] ?>"><?= $item['label'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>