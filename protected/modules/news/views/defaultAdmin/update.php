<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType() ),
        Yii::t('NewsModule.news', 'Новости') => array('/news/defaultAdmin/index'),
        $model->title => array('/news/defaultAdmin/view', 'id' => $model->id),
        Yii::t('NewsModule.news', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'Новости - редактирование');

    $this->menu = array(
        array( 'label' => Yii::t('NewsModule.news', 'Новости'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'Управление новостями'), 'url' => array('/news/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Добавить новость'), 'url' => array('/news/defaultAdmin/create')),
        )),
        array('label' => Yii::t('NewsModule.news', 'Новость') . ' «' . mb_substr($model->title, 0, 32) . '»', 'items' => array(
            array('icon' => 'pencil', 'label' => Yii::t('NewsModule.news', 'Редактирование новости'), 'url' => array(
                '/news/defaultAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('NewsModule.news', 'Просмотреть новость'), 'url' => array(
                '/news/defaultAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('NewsModule.news', 'Удалить новость'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/news/defaultAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('NewsModule.news', 'Вы уверены, что хотите удалить новость?'),
            )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Редактирование новости'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>