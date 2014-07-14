<?php
/**
 * @var $good Good
 */

$this->pageTitle = $good->name;
$assets = Yii::app()->assetManager->getPublishedUrl(
    Yii::app()->theme->basePath . "/web/"
);
?>

<?php
$this->breadcrumbs = array(
    Yii::t('CatalogModule.catalog','Products') => array('/shop/shop/index/'),
    CHtml::encode($good->name)
);
?>

<div class="post row">
    <a class="thumb span4"><?php
        echo CHtml::image(
            !$good->isNewRecord && $good->image
                ? $good->getImageUrl(270, 270)
                : $assets . '/images/no-shop-photo.jpg',
            $good->name, array(
                'class' => 'preview-image img-polaroid',
            )
        ); ?></a>

    <div class="title">
        <h1><?php echo $good->name; ?></h1>
    </div>
    <br/>
    <div class="content">


        <p><?php echo $good->description; ?></p>
    </div>
    <div class="nav">
        <span class="price"><?php echo Yii::app()->numberFormatter->formatCurrency( $good->price, 'RUR'); ?></span>
        <br/>
        <?php echo CHtml::link(Yii::t('ShopModule.shop', 'Add to basket'), array('/shop/cart/add', 'id' => $good->id), array( 'class' => 'btn')); ?>
    </div>
</div>


<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $good, 'modelId' => $good->id, 'label' => 'Отзывов')); ?>

<br/>

<h3>Оставить отзыв</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $good->getPermaLink(), 'model' => $good, 'modelId' => $good->id)); ?>
