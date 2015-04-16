<?php if (Yii::app()->getRequest()->getIsAjaxRequest() === false) : ?>

    <?php
    $this->breadcrumbs = [
        Yii::t('FeedbackModule.feedback', 'Messages ') => ['/feedback/feedbackBackend/index'],
        $model->theme,
    ];

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - view');

    $this->menu = [
        [
            'icon'  => 'fa fa-fw fa-list-alt',
            'label' => Yii::t('FeedbackModule.feedback', 'Messages management'),
            'url'   => ['/feedback/feedbackBackend/index']
        ],
        [
            'icon'  => 'fa fa-fw fa-plus-square',
            'label' => Yii::t('FeedbackModule.feedback', 'Create message '),
            'url'   => ['/feedback/feedbackBackend/create']
        ],
        [
            'label' => Yii::t('FeedbackModule.feedback', 'Reference value') . ' «' . mb_substr(
                    $model->theme,
                    0,
                    32
                ) . '»'
        ],
        [
            'icon'  => 'fa fa-fw fa-pencil',
            'label' => Yii::t('FeedbackModule.feedback', 'Edit message '),
            'url'   => [
                '/feedback/feedbackBackend/update',
                'id' => $model->id
            ]
        ],
        [
            'icon'  => 'fa fa-fw fa-eye',
            'label' => Yii::t('FeedbackModule.feedback', 'View message'),
            'url'   => [
                '/feedback/feedbackBackend/view',
                'id' => $model->id
            ]
        ],
        [
            'icon'  => 'fa fa-fw fa-envelope',
            'label' => Yii::t('FeedbackModule.feedback', 'Reply for message'),
            'url'   => [
                '/feedback/feedbackBackend/answer',
                'id' => $model->id
            ]
        ],
        [
            'icon'        => 'fa fa-fw fa-trash-o',
            'label'       => Yii::t('FeedbackModule.feedback', 'Remove message '),
            'url'         => '#',
            'linkOptions' => [
                'submit'  => ['/feedback/feedbackBackend/delete', 'id' => $model->id],
                'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                'confirm' => Yii::t('FeedbackModule.feedback', 'Do you really want to remove message?'),
            ]
        ],
    ];
    ?>

    <div class="page-header">
        <h1>
            <?php echo Yii::t('FeedbackModule.feedback', 'Show message'); ?><br/>
            <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
        </h1>
    </div>

<?php endif; ?>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'create_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
            ],
            [
                'name'  => 'update_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
            ],
            'name',
            'email',
            'phone',
            'theme',
            [
                'name' => 'text',
                'type' => 'raw'
            ],
            [
                'name'  => 'type',
                'value' => $model->getType(),
            ],
            [
                'name'  => 'category_id',
                'value' => $model->getCategory(),
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
            [
                'name' => 'answer',
                'type' => 'raw'
            ],
            [
                'name'  => 'answer_user',
                'value' => ($model->getAnsweredUser() instanceof User ? $model->getAnsweredUser()->getFullName(
                    ) : $model->getAnsweredUser()),
            ],
            [
                'name'  => 'answer_time',
                'value' => ($model->answer_time != "0000-00-00 00:00:00")
                        ? Yii::app()->dateFormatter->formatDateTime($model->answer_time, 'short')
                        : "—",
            ],
            [
                'name'  => 'is_faq',
                'value' => $model->getIsFaq(),
            ],
            'ip',
        ],
    ]
); ?>

<?php if (Yii::app()->getRequest()->getIsAjaxRequest() === true) : ?>
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'context'     => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => Yii::t('FeedbackModule.feedback', 'Ok'),
            'htmlOptions' => [
                'class'       => 'btn-block',
                'data-toggle' => 'modal',
                'data-target' => '.modal',
            ],
        ]
    ); ?>
<?php endif; ?>
