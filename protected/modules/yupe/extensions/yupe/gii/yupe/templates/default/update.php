<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php

$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->mb_ucfirst($this->mim);
$labelIm = $this->mb_ucfirst($this->im);

echo <<<EOF
<?php
    \$this->breadcrumbs = array(
        Yii::app()->getModule('{$this->mid}')->getCategory() => array(),
        Yii::t('{$this->mid}', '$label') => array('/{$this->controller}/index'),
        \$model->{$nameColumn} => array('/{$this->controller}/view', 'id' => \$model->{$this->tableSchema->primaryKey}),
        Yii::t('{$this->mid}', 'Редактирование'),
    );
    \$this->pageTitle = Yii::t('{$this->mid}', '{$label} - редактирование');
    \$this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('{$this->mid}', 'Управление {$this->mtvor}'), 'url' => array('/{$this->controller}/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('{$this->mid}', 'Добавить {$this->vin}'), 'url' => array('/{$this->controller}/create')),
        array('label' => Yii::t('{$this->mid}', '{$labelIm}')),
        array('icon' => 'pencil white', 'encodeLabel' => false, 'label' => Yii::t('{$this->mid}', 'Редактирование {$this->rod}'), 'url' => array(
            '/{$this->controller}/update',
            '{$this->tableSchema->primaryKey}' => \$model->{$this->tableSchema->primaryKey}
        )),
        array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('{$this->mid}', 'Просмотреть {$this->vin}'), 'url' => array(
            '/{$this->controller}/view',
            '{$this->tableSchema->primaryKey}' => \$model->{$this->tableSchema->primaryKey}
        )),
        array('icon' => 'trash', 'label' => Yii::t('{$this->mid}', 'Удалить {$this->vin}'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('delete', 'id' => \$model->{$this->tableSchema->primaryKey}),
            'confirm' => Yii::t('{$this->mid}', 'Вы уверены, что хотите удалить {$this->vin}?')
        )),
    );
?>
EOF;
?>

<div class="page-header">
    <h1>
        <?php echo "<?php echo Yii::t('{$this->mid}', 'Редактирование') . ' ' . Yii::t('{$this->mid}', '{$this->rod}'); ?>"; ?><br />
        <small>&laquo;<?php echo "<?php echo \$model->{$nameColumn}; ?>"; ?>&raquo;</small>
    </h1>
</div>

<?php echo "<?php echo \$this->renderPartial('_form', array('model' => \$model)); ?>"; ?>