<?php
$this->title = Yii::t('ZendSearchModule.zendsearch', 'Search by request: ') . CHtml::encode($term);
$this->breadcrumbs = [
    Yii::t('ZendSearchModule.zendsearch', 'Search by request: ') . CHtml::encode($term),
];
?>
<div class="main__title grid">
    <h1 class="h2">
        <?= Yii::t('ZendSearchModule.zendsearch', 'Search by request: '); ?>
        "<?= CHtml::encode($term); ?> "
    </h1>
</div>
<div class="main__catalog grid">
    <?= CHtml::beginForm(['/zendsearch/search/search'], 'get'); ?>
    <div class="fast-order__inputs">
        <div class="column grid-module-10">
            <?= CHtml::textField(
                'q',
                CHtml::encode($term),
                ['placeholder' => Yii::t('ZendSearchModule.zendsearch', 'Search...'), 'class' => 'input input_big']
            ); ?>
        </div>
        <div class="column grid-module-2 pull-right">
            <?= CHtml::submitButton(
                Yii::t('ZendSearchModule.zendsearch', 'Find!'),
                ['class' => 'btn btn_big btn_wide btn_primary', 'name' => '']
            ); ?>
        </div>
    </div>
    <?= CHtml::endForm(); ?>

    <div class="fast-order__inputs">
        <?php if (!empty($results)): ?>
            <h3 class="h3"><?= Yii::t('ZendSearchModule.zendsearch', 'Results:'); ?></h3>
            <?php foreach ($results as $result): ?>
                <?php
                $resultLink = '/';
                $paramsArray = [];

                $linkArray = explode('?', $result->link);
                if (isset($linkArray[0])) {
                    $resultLink = $linkArray[0];
                } else {
                    $resultLink = $result->link;
                }

                if (isset($linkArray[1])) {
                    foreach (explode('&', $linkArray[1]) as $param) {
                        $paramArray = explode('=', $param);
                        $paramsArray[$paramArray[0]] = $paramArray[1];
                    }
                }
                ?>

                <h3 class="h3">
                    <?= $query->highlightMatches(
                        CHtml::link(CHtml::encode($result->title), CController::CreateUrl($resultLink, $paramsArray)),
                        'UTF-8'
                    ); ?>
                </h3>
                <p><?= $query->highlightMatches($result->description, 'UTF-8'); ?></p>
                <hr/>
            <?php endforeach; ?>

        <?php else: ?>
            <h3 class="h3"><?= Yii::t('ZendSearchModule.zendsearch', 'Nothing was found'); ?></h3>
        <?php endif; ?>
    </div>
</div>
