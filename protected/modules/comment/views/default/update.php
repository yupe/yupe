<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('comment')->getCategory() => array(),
        Yii::t('comment', 'Комментарии') => array('/comment/default/index'),
        $model->id => array('/comment/default/view', 'id' => $model->id),
        Yii::t('comment', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('comment', 'Комментарии - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('comment', 'Управление комментариями'), 'url' => array('/comment/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('/comment/default/create')),
        array('label' => Yii::t('comment', 'Комментарий') . ' «' . mb_substr($model->id, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('comment', 'Редактирование комментария'), 'url' => array(
            '/comment/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('comment', 'Просмотреть комментарий'), 'url' => array(
            '/comment/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('comment', 'Удалить комментарий'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/comment/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('comment', 'Вы уверены, что хотите удалить комментарий?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('comment', 'Редактирование комментария'); ?><br />
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>