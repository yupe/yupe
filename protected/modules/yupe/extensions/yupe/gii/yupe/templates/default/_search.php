<?php
echo <<<EOF
<?php
\$form = \$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl(\$this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
));

Yii::app()->clientScript->registerScript('fieldset', "
    \$('document').ready(function () {
        \$('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });
");
?>\n
EOF;
?>

    <fieldset class="inline">
        <div class="row-fluid control-group">
<?php
foreach ($this->tableSchema->columns as $column)
{
    $field = $this->generateInputField($this->modelClass, $column);
    if (strpos($field, 'password') !== false)
        continue;

    $activeRow = $this->generateActiveRow($this->modelClass, $column);
    echo <<<EOF
            <div class="span2">
                <?php echo {$activeRow}; ?>
            </div>\n
EOF;
}
?>
        </div>
    </fieldset>

<?php
echo <<<EOF
    <?php \$this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('{$this->mid}', 'Искать {$this->vin}'),
    )); ?>\n
EOF;
?>

<?php echo "<?php \$this->endWidget(); ?>"; ?>