<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->mb_ucfirst($this->mim);

echo <<<EOF
<?php
    \$this->breadcrumbs = array(
        Yii::app()->getModule('{$this->mid}')->getCategory() => array(),
        Yii::t('{$this->mid}', '{$label}') => array('/{$this->controller}/index'),
        Yii::t('{$this->mid}', 'Добавление'),
    );

    \$this->pageTitle = Yii::t('{$this->mid}', '{$label} - добавление');

    \$this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('{$this->mid}', 'Управление {$this->mtvor}'), 'url' => array('/{$this->controller}/index')),
        array('icon' => 'plus-sign white', 'label' => Yii::t('{$this->mid}', 'Добавить {$this->vin}'), 'url' => array('/{$this->controller}/create')),
    );
?>
EOF;
?>

<div class="page-header">
    <h1>
        <?php echo "<?php echo Yii::t('{$this->mid}', '{$label}'); ?>\n"; ?>
        <small><?php echo "<?php echo Yii::t('{$this->mid}', 'добавление'); ?>"; ?></small>
    </h1>
</div>

<?php echo "<?php echo \$this->renderPartial('_form', array('model' => \$model)); ?>"; ?>