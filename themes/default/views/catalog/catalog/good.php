<?php $this->pageTitle = $good->name; ?>

<?php
$this->breadcrumbs = array(
    Yii::t('CatalogModule.catalog', 'Products') => array('/catalog/catalog/index/'),
    CHtml::encode($good->name)
);
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
            array('/catalog/catalog/show', 'name' => $good->alias)
        ); ?>
    </div>
</div>


<br/><br/><br/>

<?php $this->widget(
    'application.modules.comment.widgets.CommentsListWidget',
    array('model' => $good, 'modelId' => $good->id, 'label' => 'Отзывов')
); ?>

<br/>

<h3>Оставить отзыв</h3>

<?php $this->widget(
    'application.modules.comment.widgets.CommentFormWidget',
    array('redirectTo' => $good->getPermaLink(), 'model' => $good, 'modelId' => $good->id)
); ?>
