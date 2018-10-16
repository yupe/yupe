<?php $this->pageTitle = $good->name; ?>

<?php
$this->breadcrumbs = [
    Yii::t('CatalogModule.catalog', 'Products') => ['/catalog/catalog/index/'],
    CHtml::encode($good->name)
];
?>

<div class="post">
    <div class="title">
        <?php echo $good->name; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $good->description; ?></p>
    </div>
    <div class="nav">
        <?php echo Yii::t('CatalogModule.catalog', 'Price') . ': ';
        echo $good->price; ?>
        <br/>
        <?php echo CHtml::link(
            Yii::t('CatalogModule.catalog', 'Constant link'),
            ['/catalog/catalog/show', 'name' => $good->alias]
        ); ?>
    </div>
</div>


<br/><br/><br/>

<?php $this->widget(
    'application.modules.comment.widgets.CommentsListWidget',
    ['model' => $good, 'modelId' => $good->id, 'label' => 'Отзывов']
); ?>

<br/>

<h3>Оставить отзыв</h3>

<?php $this->widget(
    'application.modules.comment.widgets.CommentFormWidget',
    ['redirectTo' => $good->getPermaLink(), 'model' => $good, 'modelId' => $good->id]
); ?>
