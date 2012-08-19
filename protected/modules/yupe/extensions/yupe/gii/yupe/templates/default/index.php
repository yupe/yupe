<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
$label = $this->mb_ucfirst($this->mim);

echo <<<EOF
<?php
    \$this->breadcrumbs = array(
        Yii::app()->getModule('{$this->mid}')->getCategory() => array(),
        Yii::t('{$this->mid}', '{$label}') => array('/{$this->controller}/index'),
        Yii::t('{$this->mid}', 'Управление'),
    );

    \$this->pageTitle = Yii::t('{$this->mid}', '{$label} - управление');

    \$this->menu = array(
        array('icon' => 'list-alt white', 'label' => Yii::t('{$this->mid}', 'Управление {$this->mtvor}'),'url' => array('/{$this->controller}/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('{$this->mid}', 'Добавить {$this->vin}'), 'url' => array('/{$this->controller}/create')),
    );
?>
EOF;
?>

<div class="page-header">
    <h1>
        <?php echo "<?php echo Yii::t('{$this->mid}', '{$label}'); ?>\n"; ?>
        <small><?php echo "<?php echo Yii::t('{$this->mid}', 'управление'); ?>"; ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo "<?php echo CHtml::link(Yii::t('{$this->mid}', 'Поиск {$this->mrod}'), '#', array('class' => 'search-button')); ?>\n"; ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out">
<?php echo <<<EOF
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('{$this->class2id($this->modelClass)}-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
\$this->renderPartial('_search', array('model' => \$model));
?>\n
EOF;
?>
</div>

<br/>

<p>
    <?php echo "<?php echo Yii::t('{$this->mid}', 'В данном разделе представлены средства управления'); ?>"; ?> 
    <?php echo "<?php echo Yii::t('{$this->mid}', '{$this->mtvor}'); ?>"; ?>.
</p>


<?php echo "<?php\n"; ?>
$dp = $model->search();
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'           => '<?php echo $this->class2id($this->modelClass); ?>-grid',
    'type'         => 'condensed ',
    'pager'        => array(
        'class'         => 'bootstrap.widgets.TbPager',
        'prevPageLabel' => "←",
        'nextPageLabel' => "→",
    ),
    'dataProvider' => $dp,
    'filter'       => $model,
    'columns'      => array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column)
{
    if(++$count == 7)
        echo "    /*\n";
    echo "        '" . $column->name . "',\n";
}
if ($count >= 7)
    echo "        */\n";
?>
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>