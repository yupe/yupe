<div class="category-item">
    <a href="<?= $data['url']; ?>">
        <img src="<?= $data['icon']; ?>"/>
    </a>
    <a href="<?= $data['url']; ?>" class="category-item-title"><?= CHtml::encode($data['label']); ?></a>
    <?php if ($data['items']): ?>
        <ul>
            <?php foreach ($data['items'] as $item): ?>
                <li><a href="<?= $item['url'] ?>"><?= $item['label'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>