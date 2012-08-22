<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo <<<EOF
<?php
\$form = \$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => '{$this->class2id($this->modelClass)}-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well form-vertical'),
));

Yii::app()->clientScript->registerScript('fieldset', "
    \$('document').ready(function () {
        \$('.popover-help').popover({ 'delay' : 500 });
    });
");
?>\n
EOF;
?>

    <div class="alert alert-info">
        <?php echo "<?php echo Yii::t('{$this->mid}', 'Поля, отмеченные'); ?>"; ?> 
        <span class="required">*</span> 
        <?php echo "<?php echo Yii::t('{$this->mid}', 'обязательны.'); ?>\n"; ?>
    </div>

    <?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach ($this->tableSchema->columns as $column)
{
    if ($column->autoIncrement)
        continue;

    $activeRow = $this->generateActiveRow($this->modelClass, $column);
    echo <<<EOF
    <div class="row-fluid control-group <?php echo \$model->hasErrors('{$column->name}') ? 'error' : ''; ?>">
        <?php echo {$activeRow}; ?>
    </div>\n
EOF;
}
?>

<?php
echo <<<EOF
    <?php \$this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => \$model->isNewRecord ? Yii::t('{$this->mid}', 'Добавить {$this->vin}') : Yii::t('{$this->mid}', 'Сохранить {$this->vin}'),
    )); ?>\n
EOF;
?>

<?php echo "<?php \$this->endWidget(); ?>"; ?>