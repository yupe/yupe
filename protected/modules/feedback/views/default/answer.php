<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('/feedback/default/index'),
    Yii::t('feedback', 'Сообщения с сайта') => array('/feedback/default/index'),
    $model->theme,
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
    array('icon' => 'pencil', 'label' => Yii::t('feedback', 'Редактировать данное сообщение'), 'url' => array('/feedback/default/update', 'id' => $model->id)),
    array('icon' => 'eye-open', 'label' => Yii::t('feedback', 'Просмотр сообщения'), 'url' => array('/feedback/default/view', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('feedback', 'Удалить данное сообщение'), 'url' => '#', 'linkOptions' => array(
        'submit'  => array('delete', 'id' => $model->id),
        'confirm' => 'Подтверждаете удаление сообщения ?',
    )),
    array('icon' => 'envelope white', 'label' => Yii::t('feedback', 'Ответить на сообщение'), 'url' => array('/feedback/default/answer', 'id' => $model->id)),
);;
?>

<script type='text/javascript'>
    $(document).ready(function() {
        var email = '<?php echo $model->email; ?>';
        $('input:submit').click(function() {
            if(window.confirm('<?php echo Yii::t('feedback', 'Ответ будет отправлен на '); ?>' + email + '<?php echo Yii::t('feedback', ' продолжить ?'); ?>'))
                return true;
            return false;
        });
    });
</script>

<h1><?php echo Yii::t('feedback','Ответ на сообщение'); ?> <small>#<?php echo $model->id; ?></small></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'creation_date',
        'name',
        'email',
        'phone',
        'theme',
        array(
            'name' => 'text',
            'type' => 'raw',
        ),
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
)); ?>

<br/><br/>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'          => 'feed-back-form-answer',
        'action'      => array('/feedback/default/answer/', 'id' => $model->id),
        'htmlOptions' => array('class' => 'well'),
    )); ?>

    <fieldset class="inline">
        <div class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения'); ?></div>
        <?php echo $form->errorSummary($answerForm); ?>
        <div class="row-fluid control-group">
            <div class="span12">
                <?php echo $form->labelEx($answerForm, 'answer'); ?>
                <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                      'model'       => $answerForm,
                      'attribute'   => 'answer',
                      'options'     => array(
                           'toolbar'     => 'main',
                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
                       ),
                      'htmlOptions' => array('rows' => 20,'cols' => 6),
                 )); ?>
                <?php echo $form->error($answerForm, 'answer'); ?>
            </div>
        </div>

        <div class="row-fluid control-group">
            <div class="span12">
                <?php echo $form->checkBoxRow($answerForm, 'is_faq'); ?>
            </div>
        </div>

        <?php echo CHtml::submitButton(Yii::t('feedback', 'Отправить ответ на сообщение'), array('class' => 'btn btn-primary')); ?>
    </fieldset>
<?php $this->endWidget(); ?>