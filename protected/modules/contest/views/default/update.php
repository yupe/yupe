<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contest')->getCategory() => array(),
        Yii::t('contest', 'Конкурсы') => array('/contest/default/index'),
        $model->name => array('/contest/default/view', 'id' => $model->id),
        Yii::t('contest', 'Редактирование'),
    );
    $this->pageTitle = Yii::t('contest', 'Конкурсы - редактирование');
    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('/contest/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('/contest/default/create')),
        array('label' => Yii::t('contest', 'Конкурс')),
        array('icon' => 'pencil white', 'encodeLabel' => false, 'label' => Yii::t('contest', 'Редактирование конкурса'), 'url' => array(
            '/contest/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('contest', 'Просмотреть конкурс'), 'url' => array(
            '/contest/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('contest', 'Удалить конкурс'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('contest', 'Вы уверены, что хотите удалить конкурс?')
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('contest', 'Редактирование') . ' ' . Yii::t('contest', 'конкурса'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>