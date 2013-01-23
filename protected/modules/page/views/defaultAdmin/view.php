<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('PageModule.page', 'Страницы') => array('/page/defaultAdmin/index'),
        $model->title,
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Просмотр страницы');

    $this->menu = array(
        array('label' => Yii::t('PageModule.page', 'Страницы'), 'items' => array(   
            array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Управление страницами'), 'url' => array('/page/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Добавить страницу'), 'url' => array('/page/defaultAdmin/create')),
        )),
        array('label' => Yii::t('PageModule.page', 'Страница') . ' «' . mb_substr($model->title, 0, 32) . '»', 'items' => array(
            array('icon' => 'pencil', 'label' => Yii::t('PageModule.page', 'Редактирование страницы'), 'url' => array(
                '/page/defaultAdmin/update',
                'id'=> $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('PageModule.page', 'Просмотр страницы'), 'url' => array(
                '/page/defaultAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('PageModule.page', 'Удалить эту страницу'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/page/defaultAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('PageModule.page', 'Вы уверены, что хотите удалить страницу?'),
            )),
       ))
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
<?php echo CHtml::link(Yii::app()->createAbsoluteUrl("/page/default/show", array("slug" => $model->slug)), array('/page/default/show', 'slug' => $model->slug)); ?>