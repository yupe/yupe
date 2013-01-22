<?php
/**
 * Search form generator:
 *
 *   @category YupeGiiTemplate
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
echo <<<EOF
<?php
/**
 * Отображение для _search:
 *
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
\$form = \$this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action'      => Yii::app()->createUrl(\$this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
);
?>\n
EOF;
?>

    <fieldset class="inline">
        <div class="row-fluid control-group">
<?php
foreach ($this->tableSchema->columns as $column) {
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
    <?php
    \$this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('{$this->mid}', 'Искать {$this->vin}'),
        )
    ); ?>\n
EOF;
?>

<?php echo "<?php \$this->endWidget(); ?>"; ?>
