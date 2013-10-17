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
$label = $this->mb_ucfirst($this->mim);

echo <<<EOF
<?php
/**
 * Отображение для index:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    \$this->breadcrumbs = array(
        Yii::app()->getModule('{$this->mid}')->getCategory() => array(),
        Yii::t('{$this->mid}', '{$label}') => array('/{$this->controller}/index'),
        Yii::t('{$this->mid}', 'Управление'),
    );

    \$this->pageTitle = Yii::t('{$this->mid}', '{$label} - управление');

    \$this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('{$this->mid}', 'Управление {$this->mtvor}'), 'url' => array('/{$this->controller}/index')),
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

<div id="search-toggle" class="collapse out search-form">
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

<p> <?php echo "<?php echo Yii::t('{$this->mid}', 'В данном разделе представлены средства управления {$this->mtvor}'); ?>\n"; ?></p>

<?php echo "<?php\n"; ?> $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => '<?php echo $this->class2id($this->modelClass); ?>-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
    if(++$count == 7)
        echo "        /*\n";
    echo "        '" . $column->name . "',\n";
}
if ($count >= 7)
    echo "        */\n";
?>
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
