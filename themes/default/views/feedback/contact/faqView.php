<?php $this->pageTitle = $model->theme; ?>
<?php $this->keywords = implode(',',explode(' ',$model->theme));?>

<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Сообщения с сайта') => array('/feedback/contact/faq/'),
    $model->theme,
);
?>

<h1><?php echo Yii::t('feedback', 'Вопрос и ответ #{id}',array('{id}' => $model->id));?> <?php echo CHtml::link('ЗАДАЙТЕ ВОПРОС',array('/feedback/contact/'));?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'creation_date',
                                                        'name',
                                                        'theme',
                                                        'text',
                                                        array(
                                                            'name' => 'type',
                                                            'value' => $model->getType()
                                                        ),
                                                        array(
                                                            'name'  => 'answer_user',
                                                            'value' => $model->getAnsweredUser()
                                                        ),
                                                        'answer_date',
                                                        array(
                                                            'name' => 'answer',
                                                            'type' => 'raw'
                                                        ),
                                                    ),
                                               )); ?>



<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>
