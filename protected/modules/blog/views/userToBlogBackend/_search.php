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
            <?php echo $form->dropDownListGroup(
                $model,
                'role',
                [
                    'widgetOptions' => [
                        'data'        => $model->getRoleList(),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('role'),
                            'data-content'        => $model->getAttributeDescription('role'),
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
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('status'),
                            'data-content'        => $model->getAttributeDescription('status'),
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
                'user_id',
                [
                    'widgetOptions' => [
                        'data'        => User::getFullNameList(),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('user_id'),
                            'data-content'        => $model->getAttributeDescription('user_id'),
                        ],
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'blog_id',
                [
                    'widgetOptions' => [
                        'data'        => CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => [
                            'empty'               => '---',
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('blog_id'),
                            'data-content'        => $model->getAttributeDescription('blog_id'),
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
                'note',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('note'),
                            'data-content'        => $model->getAttributeDescription('note')
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
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'BlogModule.blog',
                'Find a member'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
