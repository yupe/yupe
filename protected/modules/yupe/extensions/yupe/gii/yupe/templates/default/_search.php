<?php
/**
 * Search form generator:
 *
 * @category YupeGiiTemplate
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
echo <<<EOF
<?php
/**
 * Отображение для _search:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
\$form = \$this->beginWidget(
    'bootstrap.widgets.TbActiveForm', [
        'action'      => Yii::app()->createUrl(\$this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
);
?>\n
EOF;
?>

<fieldset>
    <div class="row">
        <?php foreach ($this->tableSchema->columns as $column) {
            $field = $this->generateInputField($this->modelClass, $column);
            if (strpos($field, 'password') !== false) {
                continue;
            }

            $activeRow = $this->generateActiveGroup($this->modelClass, $column);
            echo <<<EOF
<div class="col-sm-3">
            <?php echo {$activeRow}; ?>
        </div>\n\t\t
EOF;
        } ?>
    </div>
</fieldset>

<?php
echo <<<EOF
    <?php \$this->widget(
        'bootstrap.widgets.TbButton', [
            'context'     => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t('{$this->getModuleTranslate()}', 'Искать {$this->vin}'),
        ]
    ); ?>\n
EOF;
?>

<?php echo "<?php \$this->endWidget(); ?>"; ?>