<?php $this->pageTitle = $model->theme; ?>
<?php $this->keywords = implode(',',explode(' ',$model->theme));?>

<?php
$this->breadcrumbs = array(
    'Вопросы и ответы' => array('/feedback/contact/faq/'),
    $model->theme,
);
?>

<h1><?php echo Yii::t('feedback', 'Вопрос и ответ #{id}',array('{id}' => $model->id));?> <?php echo CHtml::link('ЗАДАЙТЕ ВОПРОС',array('/feedback/index/'));?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'creation_date',
                                                        'name',
                                                        'theme',
                                                        array(
                                                            'name' => 'text',
                                                            'type' => 'raw',
                                                            'value' => $model->text,
                                                        ),

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

<br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('label' => 'Мнений','model' => $model, 'modelId' => $model->id)); ?>

<br/>

<h3>У Вас есть свое мнение по этому вопросу !? Поделитесь им!</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/feedback/contact/faqView/', array('id' => $model->id)), 'model' => $model, 'modelId' => $model->id)); ?>


