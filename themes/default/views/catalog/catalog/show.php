<?php
/**
 * @var $this CatalogController
 * @var $model Good
 */

$this->title = [$model->name, $model->category->name, Yii::app()->getModule('yupe')->siteName];
?>

<?php
$this->breadcrumbs = [
    Yii::t('CatalogModule.catalog', 'Products') => ['/catalog/catalog/index/'],
    $model->name
];
?>
<div class="row">
    <div class="col-sm-12">
        <h1 class="title"> <?= $model->name; ?></h1>
    </div>
</div>
<div class="row form-group">
    <?= CHtml::image($model->getImageUrl(), $model->name, ['class' => 'col-sm-9']); ?>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <?= $model->description; ?>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-2">
        <?= Yii::t('CatalogModule.catalog', 'Price') . ': ' . number_format($model->price, 2, ',', ' '); ?> <i class="fa fa-rub"></i>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h3><?= Yii::t('CatalogModule.catalog', 'Comments') ?></h3>
        <hr/>
        <?php $this->widget('application.modules.comment.widgets.CommentsWidget', [
            'redirectTo' => $model->getUrl(),
            'model' => $model,
        ]); ?>
    </div>
</div>

