<?php Yii::import('application.modules.menu.components.YMenu'); ?>
<?php foreach ($this->params['items'] as $item): ?>
    <div class="footer__item">
        <?= CHtml::link(CHtml::encode($item['label']), $item['url'], ['class' => 'footer__link']); ?>
    </div>
<?php endforeach; ?>