<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('page')->getCategory() => array(),
        Yii::t('PageModule.page', 'Страницы') => array('/page/default/index'),
        $model->title,
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Просмотр страницы');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Список страниц'), 'url' => array('/page/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Добавить страницу'), 'url' => array('/page/default/create')),
        array('label' => Yii::t('PageModule.page', 'Страница') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('PageModule.page', 'Редактирование страницы'), 'url' => array(
            '/page/default/update',
            'slug'=> $model->slug
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('PageModule.page', 'Просмотр страницы'), 'url' => array(
            '/page/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('PageModule.page', 'Удалить эту страницу'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/page/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('PageModule.page', 'Вы уверены, что хотите удалить страницу?'),
        )),
    );
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Просмотр страницы'); ?>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<h2><?php echo $model->title; ?></h2>

<small><?php echo Yii::t('PageModule.page', 'Автор'); ?>: <?php echo $model->changeAuthor->getFullName(); ?></small>
<br /><br />

<p><?php echo $model->body; ?></p>
<br/>

<li class="icon-globe">&nbsp;</li> 
<?php echo CHtml::link(Yii::app()->createAbsoluteUrl("/page/page/show", array("slug" => $model->slug)), array('/page/page/show', 'slug' => $model->slug)); ?>
