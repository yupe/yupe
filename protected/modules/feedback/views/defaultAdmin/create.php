<?php
	$feedback = Yii::app()->getModule('feedback');
	$this->breadcrumbs = array(
		$feedback->getCategory() => array('/yupe/backend/index', 'category' => $feedback->getCategoryType() ),
        Yii::t('FeedbackModule.feedback', 'Сообщения с сайта') => array('/feedback/defaultAdmin/index'),
        Yii::t('FeedbackModule.feedback', 'Добавление'),
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Сообщения с сайта - добавление');

    $this->menu = array(
    	array('label' => Yii::t('FeedbackModule.feedback', 'Сообщения с сайта'), 'items' => array(
			array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Управление сообщениями с сайта'), 'url' => array('/feedback/defaultAdmin/index')),
        	array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Добавить сообщение с сайта'), 'url' => array('/feedback/defaultAdmin/create')),
    	)),
    );
?>
<h1>
    <?php echo Yii::t('FeedbackModule.feedback', 'Сообщения с сайта'); ?>
    <small><?php echo Yii::t('FeedbackModule.feedback', 'добавление'); ?></small>
</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>