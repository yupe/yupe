<?php
/**
 * Файл представления menu/_search:
 *
 * @category YupeViews
 * @package  yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>

    <fieldset class="inline">
        <div class="wide row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'name'); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'code'); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => '----')); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'description'); ?>
            </div>
        </div>
    </fieldset>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('MenuModule.menu', 'Find menu'),
        )
    ); ?>

<?php $this->endWidget(); ?>
