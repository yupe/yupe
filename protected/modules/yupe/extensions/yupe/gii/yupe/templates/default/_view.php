<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="view">

<?php
echo <<<EOF
    <b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>: </b>
    <?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}), array('view', 'id' => \$data->{$this->tableSchema->primaryKey})); ?>
    <br />\n\n
EOF;
$count = 0;
foreach ($this->tableSchema->columns as $column)
{
    if ($column->isPrimaryKey)
        continue;
    if (++$count == 7)
        echo "    <?php /*\n";
    echo <<<EOF
    <b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>: </b>
    <?php echo CHtml::encode(\$data->{$column->name}); ?>
    <br />\n\n
EOF;
}
if ($count >= 7)
    echo "    */ ?>\n";
?>
</div>