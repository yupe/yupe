<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('feedback')->getCategory() => array(),
        Yii::t('feedback', 'Сообщения с сайта') => array('/feedback/default/index'),
        $model->theme => array('/feedback/default/view', 'id' => $model->id),
        Yii::t('feedback', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('feedback', 'Управление сообщениями с сайта'), 'url' => array('/feedback/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('feedback', 'Добавить сообщение с сайта'), 'url' => array('/feedback/default/create')),
        array('label' => Yii::t('dictionary', 'Значение справочника') . ' «' . mb_substr($model->theme, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('feedback', 'Редактирование сообщения с сайта'), 'url' => array(
            '/feedback/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('feedback', 'Просмотреть сообщение с сайта'), 'url' => array(
            '/feedback/default/view',
            'id' => $model->id
        )),
        array('icon' => 'envelope', 'label' => Yii::t('feedback', 'Ответить на сообщение с сайта'), 'url' => array(
            '/feedback/default/answer',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('feedback', 'Удалить сообщение с сайта'), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/feedback/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('feedback', 'Вы уверены, что хотите удалить сообщение с сайта?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('feedback', 'Редактировать сообщение с сайта '); ?><br />
        <small>&laquo;<?php echo $model->theme; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>