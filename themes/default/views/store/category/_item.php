<div class="category-item">
    <?php if ($data['icon']): ?>
        <div class="category-image text-center">
            <a href="<?= $data['url']; ?>">
                <img src="<?= $data['icon']; ?>" alt="<?= $data['icon_alt']; ?>" title="<?= $data['icon_title']; ?>"/>
            </a>
        </div>
    <?php endif; ?>
    <a href="<?= $data['url']; ?>" class="category-item-title"><?= CHtml::encode($data['label']); ?></a>
    <?php if ($data['items']): ?>
        <ul>
            <?php foreach ($data['items'] as $item): ?>
                <li><a href="<?= $item['url'] ?>"><?= $item['label'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>