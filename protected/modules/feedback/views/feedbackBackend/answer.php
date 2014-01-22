<?php
    $this->breadcrumbs = array(      
        Yii::t('FeedbackModule.feedback', 'Messages ') => array('/feedback/feedbackBackend/index'),
        $model->theme => array('/feedback/feedbackBackend/view', 'id' => $model->id),
        Yii::t('FeedbackModule.feedback', 'Reply'),
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - answer');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Messages management'), 'url' => array('/feedback/feedbackBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Create message '), 'url' => array('/feedback/feedbackBackend/create')),
        array('label' => Yii::t('FeedbackModule.feedback', 'Reference value') . ' «' . mb_substr($model->theme, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('FeedbackModule.feedback', 'Edit message '), 'url' => array(
            '/feedback/feedbackBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('FeedbackModule.feedback', 'View message'), 'url' => array(
            '/feedback/feedbackBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'envelope', 'label' => Yii::t('FeedbackModule.feedback', 'Reply for message'), 'url' => array(
            '/feedback/feedbackBackend/answer',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('FeedbackModule.feedback', 'Remove message '), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/feedback/feedbackBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('FeedbackModule.feedback', 'Do you really want to remove message?'),
        )),
    );
?>

    <script type='text/javascript'>
        $(document).ready(function() {
            var email = '<?php echo $model->email; ?>';
            $('input:submit').click(function() {
                if(window.confirm('<?php echo Yii::t('FeedbackModule.feedback', 'Reply will be send on '); ?>' + email + '<?php echo Yii::t('FeedbackModule.feedback', ' продолжить ?'); ?>'))
                    return true;
                return false;
            });
        });
    </script>
    
    <div class="page-header">
        <h1>
            <?php echo Yii::t('FeedbackModule.feedback', 'Reply on message'); ?><br />
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
        'action'                 => array('/feedback/feedbackBackend/answer', 'id' => $model->id),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
        'inlineErrors'           => true,
    )); ?>
        <div class="alert alert-info">
            <?php echo Yii::t('FeedbackModule.feedback', 'Fields with'); ?>
            <span class="required">*</span>
            <?php echo Yii::t('FeedbackModule.feedback', 'are required.'); ?>
        </div>

        <?php echo $form->errorSummary($answerForm); ?>

        <div class="row-fluid control-group">
            <div class="span12">
                <?php echo $form->labelEx($answerForm, 'answer'); ?>
                <?php $this->widget($this->yupe->editor, array(
                      'model'       => $answerForm,
                      'attribute'   => 'answer',
                      'options'     => array(
                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxImageUpload/',
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

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => Yii::t('FeedbackModule.feedback', 'Send reply for message'),
        )); ?>

<?php $this->endWidget(); ?>
