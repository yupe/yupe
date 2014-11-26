<?php
/**
 * Отображение для blogBackend/_search:
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
                'name',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('name'),
                            'data-content'        => $model->getAttributeDescription('name'),
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
                'type',
                [
                    'widgetOptions' => [
                        'data'        => $model->getTypeList(),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('type'),
                            'data-content'        => $model->getAttributeDescription('type'),
                        ],
                    ],
                ]
            ); ?>
        </div>
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
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup(
                $model,
                'description',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('description'),
                            'data-content'        => $model->getAttributeDescription('description'),
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
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t('BlogModule.blog', 'Find a blog'),
    ]
); ?>

<?php $this->endWidget(); ?>
