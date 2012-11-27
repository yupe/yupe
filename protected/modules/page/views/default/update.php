<?php
    $this->breadcrumbs = array(
        $this->getModule('page')->getCategory() => array('/page/default/index'),
        Yii::t('page', 'Страницы') => array('/page/default/index'),
        $model->title => array('/page/default/view', 'id' => $model->id),
        Yii::t('page', 'Изменение'),
    );

    $this->pageTitle = Yii::t('page', 'Редактирование страницы');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление страницами'), 'url' => array('/page/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
        array('label' => Yii::t('page', 'Страница') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('page', 'Редактирование страницы'), 'url' => array('/page/default/update', 'id'=> $model->id)),
        array('icon' => 'eye-open', 'encodeLabel'=> false, 'label' => Yii::t('page', 'Просмотр страницы'), 'url' => array('/page/default/view', 'id' => $model->id)),
        array('icon' => 'remove', 'label' => Yii::t('page', 'Удалить эту страницу'), 'url' => '#', 'linkOptions' => array('submit' => array('/page/default/delete', 'id' => $model->id), 'confirm' => Yii::t('page', 'Подтверждаете удаление страницы ?'))),
    );
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('page', 'Редактирование записи'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>