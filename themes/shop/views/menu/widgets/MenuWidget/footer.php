<?php foreach ($this->params['items'] as $item): ?>
    <?php if ($item['visible']): ?>
        <div class="footer__item">
            <?= CHtml::link(CHtml::encode($item['label']), $item['url'], ['class' => 'footer__link']); ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>