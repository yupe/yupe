<?php
$this->title = Yii::t('ZendSearchModule.zendsearch', 'Search by request: ') . CHtml::encode($term);
$this->breadcrumbs = [
    Yii::t('ZendSearchModule.zendsearch', 'Search by request: ') . CHtml::encode($term),
];
?>
<h1><?= Yii::t('ZendSearchModule.zendsearch', 'Search by request: '); ?> "<?= CHtml::encode($term); ?>
    "</h1>

<?= CHtml::beginForm(['/zendsearch/search/search'], 'get', ['class' => 'form-inline']); ?>
<?= CHtml::textField(
    'q',
    CHtml::encode($term),
    ['placeholder' => Yii::t('ZendSearchModule.zendsearch', 'Search...'), 'class' => 'form-control']
); ?>
<?= CHtml::submitButton(
    Yii::t('ZendSearchModule.zendsearch', 'Find!'),
    ['class' => 'btn btn-default', 'name' => '']
); ?>
<?= CHtml::endForm(); ?>


<?php if (!empty($results)): ?>
    <h3><?= Yii::t('ZendSearchModule.zendsearch', 'Results:'); ?></h3>
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

        <h3>
            <?= $query->highlightMatches(
                CHtml::link(CHtml::encode($result->title), CController::CreateUrl($resultLink, $paramsArray)),
                'UTF-8'
            ); ?>
        </h3>
        <p><?= $query->highlightMatches($result->description, 'UTF-8'); ?></p>
        <hr/>
    <?php endforeach; ?>

<?php else: ?>
    <p class="error"><?= Yii::t('ZendSearchModule.zendsearch', 'Nothing was found'); ?></p>
<?php endif; ?>
