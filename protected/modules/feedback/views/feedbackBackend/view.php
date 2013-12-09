<?php if (Yii::app()->getRequest()->getIsAjaxRequest() === false) : ?>

    <?php
        $this->breadcrumbs = array(          
            Yii::t('FeedbackModule.feedback', 'Messages ') => array('/feedback/feedbackBackend/index'),
            $model->theme,
        );

        $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - view');

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

    <div class="page-header">
        <h1>
            <?php echo Yii::t('FeedbackModule.feedback', 'Show message'); ?><br />
            <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
        </h1>
    </div>

<?php endif; ?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'creation_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->creation_date, "short", "short"),
        ),
        array(
            'name'  => 'change_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->change_date, "short", "short"),
        ),
        'name',
        'email',
        'phone',
        'theme',
         array(
            'name' => 'text',
            'type' => 'raw'
        ),
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name'  => 'category_id',
            'value' => $model->getCategory(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name' => 'answer',
            'type' => 'raw'
        ),
        array(
            'name'  => 'answer_user',
            'value' => $model->getAnsweredUser(),
        ),
        array(
            'name'  => 'answer_date',
            'value' => ($model->answer_date != "0000-00-00 00:00:00")
                ? Yii::app()->dateFormatter->formatDateTime($model->answer_date, 'short')
                : "—",
        ),
        array(
            'name'  => 'is_faq',
            'value' => $model->getIsFaq(),
        ),
        'ip',
    ),
)); ?>

<?php if (Yii::app()->getRequest()->getIsAjaxRequest() === true) : ?>
    <?php $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => Yii::t('FeedbackModule.feedback', 'Ok'),
            'htmlOptions' => array(
                'class' => 'btn-block',
                'data-toggle' => 'modal',
                'data-target' => '.modal',
            ),
        )
    ); ?>
<?php endif; ?>