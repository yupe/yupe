<?php
    $this->breadcrumbs = array(        
        Yii::t('PageModule.page', 'Pages') => array('/page/pageBackend/index'),
        $model->title,
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Show page');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Pages list'), 'url' => array('/page/pageBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Create page'), 'url' => array('/page/pageBackend/create')),
        array('label' => Yii::t('PageModule.page', 'Page') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('PageModule.page', 'Edit page'), 'url' => array(
            '/page/pageBackend/update',
            'slug'=> $model->slug
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('PageModule.page', 'Show page'), 'url' => array(
            '/page/pageBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('PageModule.page', 'Remove this page'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/page/pageBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('PageModule.page', 'Do you really want to remove page?'),
        )),
    );
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Show page'); ?>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<h2><?php echo $model->title; ?></h2>

<small><?php echo Yii::t('PageModule.page', 'Author'); ?>: <?php echo $model->changeAuthor->getFullName(); ?></small>
<br /><br />

<p><?php echo $model->body; ?></p>
<br/>

<li class="icon-globe">&nbsp;</li> 
<?php echo CHtml::link(Yii::app()->createAbsoluteUrl("/page/page/show", array("slug" => $model->slug)), array('/page/page/show', 'slug' => $model->slug)); ?>
