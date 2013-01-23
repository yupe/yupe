<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('PageModule.page', 'Страницы') => array('/page/defaultAdmin/index'),
        $model->title => array('/page/defaultAdmin/view', 'id' => $model->id),
        Yii::t('PageModule.page', 'Изменение'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Редактирование страницы');

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
        <?php echo Yii::t('PageModule.page', 'Редактирование записи'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>