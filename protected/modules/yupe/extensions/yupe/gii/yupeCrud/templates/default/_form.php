<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 *
 * @category YupeGiiTemplate
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
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
 *
 *   @var \$model {$this->modelClass}
 *   @var \$form TbActiveForm
 *   @var \$this {$this->controllerClass}
 **/
\$form = \$this->beginWidget(
    'bootstrap.widgets.TbActiveForm', [
        'id'                     => '{$this->class2id($this->modelClass)}-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => ['class' => 'well'],
    ]
);
?>\n
EOF;
?>

<div class="alert alert-info">
    <?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', 'Поля, отмеченные'); ?>\n"; ?>
    <span class="required">*</span>
    <?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', 'обязательны.'); ?>\n"; ?>
</div>

<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach ($this->tableSchema->columns as $column) {
    if ($column->autoIncrement) {
        continue;
    }

    $activeRow = $this->generateActiveGroup($this->modelClass, $column);
    echo <<<EOF
    <div class="row">
        <div class="col-sm-7">
            <?php echo {$activeRow}; ?>
        </div>
    </div>\n
EOF;
}
?>

<?php
echo <<<EOF
    <?php \$this->widget(
        'bootstrap.widgets.TbButton', [
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('{$this->getModuleTranslate()}', 'Сохранить {$this->vin} и продолжить'),
        ]
    ); ?>
    <?php \$this->widget(
        'bootstrap.widgets.TbButton', [
            'buttonType' => 'submit',
            'htmlOptions'=> ['name' => 'submit-type', 'value' => 'index'],
            'label'      => Yii::t('{$this->getModuleTranslate()}', 'Сохранить {$this->vin} и закрыть'),
        ]
    ); ?>\n
EOF;
?>

<?php echo "<?php \$this->endWidget(); ?>"; ?>
