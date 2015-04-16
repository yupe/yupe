<?php
/**
 * Отображение для postBackend/_search:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
);

?>

<fieldset>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'title',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('title'),
                            'data-content'        => $model->getAttributeDescription('title'),
                        ],
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'slug',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('slug'),
                            'data-content'        => $model->getAttributeDescription('slug'),
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'blog_id',
                [
                    'widgetOptions' => [
                        'data'        => CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('blog_id'),
                            'data-content'        => $model->getAttributeDescription('blog_id'),
                        ],
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'publish_time',
                [
                    'widgetOptions' => [
                        'options'     => [
                            'format'    => 'yy-mm-dd',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ],
                        'htmlOptions' => [
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('publish_time'),
                            'data-content'        => $model->getAttributeDescription('publish_time'),
                        ],
                    ],
                    'prepend'       => '<i class="fa fa-calendar"></i>',
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                [
                    'widgetOptions' => [
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('status'),
                            'data-content'        => $model->getAttributeDescription('status'),
                        ],
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'access_type',
                [
                    'widgetOptions' => [
                        'data'        => $model->getAccessTypeList(),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('access_type'),
                            'data-content'        => $model->getAttributeDescription('access_type'),
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'link',
                [
                    'class'               => 'popover-help',
                    'data-original-title' => $model->getAttributeLabel('link'),
                    'data-content'        => $model->getAttributeDescription('link')
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'comment_status',
                [
                    'widgetOptions' => [
                        'data'        => $model->getCommentStatusList(),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('comment_status'),
                            'data-content'        => $model->getAttributeDescription('comment_status')
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'description',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('description'),
                            'data-content'        => $model->getAttributeDescription('description'),
                        ],
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'keywords',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('keywords'),
                            'data-content'        => $model->getAttributeDescription('keywords'),
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
</fieldset>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t('BlogModule.blog', 'Find a post'),
    ]
); ?>

<?php $this->endWidget(); ?>
