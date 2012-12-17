<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('gallery')->getCategory() => array(),
        Yii::t('gallery', 'Галереи') => array('/gallery/default/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('gallery', 'Галереи - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('gallery', 'Список галарей'), 'url' => array('/gallery/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
        array('label' => Yii::t('gallery', 'Галерея') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('gallery', 'Редактирование галереи'), 'url' => array(
            '/gallery/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('gallery', 'Просмотреть галерею'), 'url' => array(
            '/gallery/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('gallery', 'Удалить галерею'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/gallery/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('gallery', 'Вы уверены, что хотите удалить галерею?'),
        )),
    );
?>
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('gallery', 'Просмотр галереи'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
        'description',
        array(
            'name'  => 'status',
            'value' => $model->getStatus()
        ),
    ),
)); ?>