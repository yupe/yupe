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
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
);

?>

<fieldset>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'role',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getRoleList(),
                        'htmlOptions' => array(
                            'empty'               => '---',
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('role'),
                            'data-content'        => $model->getAttributeDescription('role'),
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => array(
                            'empty'               => '---',
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('status'),
                            'data-content'        => $model->getAttributeDescription('status'),
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'user_id',
                array(
                    'widgetOptions' => array(
                        'data'        => CHtml::listData(User::model()->findAll(), 'id', 'nick_name'),
                        'htmlOptions' => array(
                            'empty'               => '---',
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('user_id'),
                            'data-content'        => $model->getAttributeDescription('user_id'),
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'blog_id',
                array(
                    'widgetOptions' => array(
                        'data'        => CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => array(
                            'empty'               => '---',
                            'class'               => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('blog_id'),
                            'data-content'        => $model->getAttributeDescription('blog_id'),
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup(
                $model,
                'note',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('note'),
                            'data-content'        => $model->getAttributeDescription('note')
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>
</fieldset>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'BlogModule.blog',
                'Find a member'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
