<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contest')->getCategory() => array(),
        Yii::t('contest', 'Конкурсы') => array('/contest/default/index'),
        $model->name,
    );
    $this->pageTitle = Yii::t('contest', 'Конкурсы - просмотр');
    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('/contest/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('/contest/default/create')),
        array('label' => Yii::t('contest', 'Конкурс')),
        array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('contest', 'Редактирование конкурса'), 'url' => array(
            '/contest/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open white', 'encodeLabel' => false, 'label' => Yii::t('contest', 'Просмотреть конкурс'), 'url' => array(
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
        <?php echo Yii::t('contest', 'Просмотр') . ' ' . Yii::t('contest', 'конкурса'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
        'description',
        'start_add_image',
        'stop_add_image',
        'start_vote',
        'stop_vote',
        'status',
    ),
)); ?>
