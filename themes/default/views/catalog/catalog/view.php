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

<div class="post">
    <div class="title">
        <?php echo $model->name; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $model->description; ?></p>
    </div>
    <div class="nav">
        <?php echo Yii::t('CatalogModule.catalog', 'Price') . ': ';
        echo $model->price; ?>
        <br/>
        <?php echo CHtml::link(
            Yii::t('CatalogModule.catalog', 'Constant link'),
            $model->createUrl()
        ); ?>
    </div>
</div>


<br/><br/><br/>

<?php $this->widget(
    'application.modules.comment.widgets.CommentsListWidget',
    ['model' => $model, 'modelId' => $model->id, 'label' => 'Отзывов']
); ?>

<br/>

<h3>Оставить отзыв</h3>

<?php $this->widget(
    'application.modules.comment.widgets.CommentFormWidget',
    ['redirectTo' => $model->createUrl(), 'model' => $model, 'modelId' => $model->id]
); ?>
