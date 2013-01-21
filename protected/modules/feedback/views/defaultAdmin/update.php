<?php
	$feedback = Yii::app()->getModule('feedback');
	$this->breadcrumbs = array(
	    $feedback->getCategory() => array('/yupe/backend/index', 'category' => $feedback->getCategoryType() ),
        Yii::t('FeedbackModule.feedback', 'Сообщения с сайта') => array('/feedback/defaultAdmin/index'),
        $model->theme => array('/feedback/defaultAdmin/view', 'id' => $model->id),
        Yii::t('FeedbackModule.feedback', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Сообщения с сайта - редактирование');

    $this->menu = array(
        array('label' => Yii::t('FeedbackModule.feedback', 'Сообщения с сайта'), 'items' => array(
		    array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Управление сообщениями с сайта'), 'url' => array('/feedback/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Добавить сообщение с сайта'), 'url' => array('/feedback/defaultAdmin/create')),
    	)),
        array('label' => Yii::t('dictionary', 'Значение справочника') . ' «' . mb_substr($model->theme, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('FeedbackModule.feedback', 'Редактирование сообщения с сайта'), 'url' => array(
            '/feedback/defaultAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('FeedbackModule.feedback', 'Просмотреть сообщение с сайта'), 'url' => array(
            '/feedback/defaultAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'envelope', 'label' => Yii::t('FeedbackModule.feedback', 'Ответить на сообщение с сайта'), 'url' => array(
            '/feedback/defaultAdmin/answer',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('FeedbackModule.feedback', 'Удалить сообщение с сайта'), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/feedback/defaultAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('FeedbackModule.feedback', 'Вы уверены, что хотите удалить сообщение с сайта?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Редактировать сообщение с сайта '); ?><br />
        <small>&laquo;<?php echo $model->theme; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>