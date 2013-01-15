<?php
	$feedback = Yii::app()->getModule('feedback');
	$this->breadcrumbs = array(
		$feedback->getCategory() => array('/yupe/backend/index', 'category' => $feedback->getCategoryType() ),
        Yii::t('FeedbackModule.feedback', 'Сообщения с сайта') => array('/feedback/defaultAdmin/index'),
        $model->theme => array('/feedback/defaultAdmin/view', 'id' => $model->id),
        Yii::t('FeedbackModule.feedback', 'Ответ'),
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Сообщения с сайта - ответ');

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

    <script type='text/javascript'>
        $(document).ready(function() {
            var email = '<?php echo $model->email; ?>';
            $('input:submit').click(function() {
                if(window.confirm('<?php echo Yii::t('FeedbackModule.feedback', 'Ответ будет отправлен на '); ?>' + email + '<?php echo Yii::t('FeedbackModule.feedback', ' продолжить ?'); ?>'))
                    return true;
                return false;
            });
        });
    </script>
    
    <div class="page-header">
        <h1>
            <?php echo Yii::t('FeedbackModule.feedback', 'Ответ на сообщение с сайта '); ?><br />
            <small>&laquo;<?php echo $model->theme; ?>&raquo;</small>
        </h1>
    </div>
    
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

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'feed-back-form-answer',
        'action'                 => array('/feedback/defaultAdmin/answer', 'id' => $model->id),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
        'inlineErrors'           => true,
    ));

    Yii::app()->clientScript->registerScript('fieldset', "
        $('document').ready(function () {
            $('.popover-help').popover({ trigger : 'hover', delay : 500 });
        });
    ");
    ?>
        <div class="alert alert-info">
            <?php echo Yii::t('FeedbackModule.feedback', 'Поля, отмеченные'); ?>
            <span class="required">*</span>
            <?php echo Yii::t('FeedbackModule.feedback', 'обязательны.'); ?>
        </div>

        <?php echo $form->errorSummary($answerForm); ?>
        <div class="row-fluid control-group">
            <div class="span12">
                <?php echo $form->labelEx($answerForm, 'answer'); ?>
                <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                      'model'       => $answerForm,
                      'attribute'   => 'answer',
                      'options'     => $this->module->editorOptions,
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

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => Yii::t('FeedbackModule.feedback', 'Отправить ответ на сообщение с сайта'),
        )); ?>

<?php $this->endWidget(); ?>