<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('gallery')->getCategory() => array(),
        Yii::t('gallery', 'Галереи') => array('/gallery/default/index'),
        $model->name => array('/gallery/default/view', 'id' => $model->id),
        Yii::t('gallery', 'Редактирование'),
    );
    $this->pageTitle = Yii::t('gallery', 'Галереи - редактирование');
    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('gallery', 'Управление галлереями'), 'url' => array('/gallery/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
        array('label' => Yii::t('gallery', 'Галерея')),
        array('icon' => 'pencil white', 'encodeLabel' => false, 'label' => Yii::t('gallery', 'Редактирование галереи'), 'url' => array(
            '/gallery/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('gallery', 'Просмотреть галерею'), 'url' => array(
            '/gallery/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('gallery', 'Удалить галерею'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('gallery', 'Вы уверены, что хотите удалить галерею?')
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('gallery', 'Редактирование') . ' ' . Yii::t('gallery', 'галереи'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>