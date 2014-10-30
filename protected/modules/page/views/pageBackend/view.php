<?php
$this->breadcrumbs = array(
    Yii::t('PageModule.page', 'Pages') => array('/page/pageBackend/index'),
    $model->title,
);

$this->pageTitle = Yii::t('PageModule.page', 'Show page');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('PageModule.page', 'Pages list'),
        'url'   => array('/page/pageBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('PageModule.page', 'Create page'),
        'url'   => array('/page/pageBackend/create')
    ),
    array('label' => Yii::t('PageModule.page', 'Page') . ' «' . mb_substr($model->title, 0, 32) . '»'),
    array(
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('PageModule.page', 'Edit page'),
        'url'   => array(
            '/page/pageBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('PageModule.page', 'Show page'),
        'url'   => array(
            '/page/pageBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('PageModule.page', 'Remove this page'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/page/pageBackend/delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('PageModule.page', 'Do you really want to remove page?'),
        )
    ),
);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Show page'); ?>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<h2><?php echo $model->title; ?></h2>

<small><?php echo Yii::t('PageModule.page', 'Author'); ?>
    : <?php echo ($model->changeAuthor instanceof User) ? $model->changeAuthor->getFullName() : Yii::t(
        'PageModule.page',
        'Removed'
    ); ?></small>
<br/>
<br/>

<p><?php echo $model->body; ?></p>
<br/>

<li class="fa fa-fw fa-globe"></li>
<?php echo CHtml::link($model->getUrl(true), $model->getUrl()); ?>
