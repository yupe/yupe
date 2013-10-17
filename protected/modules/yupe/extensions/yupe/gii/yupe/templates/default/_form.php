<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 *
 *   @category YupeGiiTemplate
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 */
?>
<?php
echo <<<EOF
<?php
/**
 * Отображение для _form:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
\$form = \$this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => '{$this->class2id($this->modelClass)}-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
        'inlineErrors'           => true,
    )
);
?>\n
EOF;
?>

    <div class="alert alert-info">
        <?php echo "<?php echo Yii::t('{$this->mid}', 'Поля, отмеченные'); ?>\n"; ?>
        <span class="required">*</span>
        <?php echo "<?php echo Yii::t('{$this->mid}', 'обязательны.'); ?>\n"; ?>
    </div>

    <?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach ($this->tableSchema->columns as $column) {
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
    <?php
    \$this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => Yii::t('{$this->mid}', 'Сохранить {$this->vin} и закрыть'),
        )
    ); ?>
    <?php
    \$this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
            'label'      => Yii::t('{$this->mid}', 'Сохранить {$this->vin} и продолжить'),
        )
    ); ?>\n
EOF;
?>

<?php echo "<?php \$this->endWidget(); ?>"; ?>
