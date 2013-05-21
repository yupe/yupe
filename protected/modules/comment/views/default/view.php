<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('comment')->getCategory() => array(),
        Yii::t('CommentModule.comment', 'Комментарии') => array('/comment/default/index'),
        $model->id,
    );

    $this->pageTitle = Yii::t('CommentModule.comment', 'Комментарии - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Управление комментариями'), 'url' => array('/comment/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CommentModule.comment', 'Добавить комментарий'), 'url' => array('/comment/default/create')),
        array('label' => Yii::t('CommentModule.comment', 'Комментарий') . ' «' . mb_substr($model->id, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('CommentModule.comment', 'Редактирование комментария'), 'url' => array(
            '/comment/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('CommentModule.comment', 'Просмотреть комментарий'), 'url' => array(
            '/comment/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('CommentModule.comment', 'Удалить комментарий'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/comment/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('CommentModule.comment', 'Вы уверены, что хотите удалить комментарий?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('catalog', 'Просмотр комментария'); ?><br />
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'model',
        'model_id',
        array(
            'name'  => 'creation_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->creation_date, "short", "short"),
        ),
        'name',
        'email',
        'url',
        'text',
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        'ip',
    ),
)); ?>
