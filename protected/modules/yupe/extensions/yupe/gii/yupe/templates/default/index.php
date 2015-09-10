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
\$this->breadcrumbs = [
    \$this->getModule()->getCategory() => [],
    Yii::t('{$this->getModuleTranslate()}', '{$label}') => ['/{$this->mid}/{$this->controller}/index'],
    Yii::t('{$this->getModuleTranslate()}', 'Управление'),
];

\$this->pageTitle = Yii::t('{$this->getModuleTranslate()}', '{$label} - управление');

\$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('{$this->getModuleTranslate()}', 'Управление {$this->mtvor}'), 'url' => ['/{$this->mid}/{$this->controller}/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('{$this->getModuleTranslate()}', 'Добавить {$this->vin}'), 'url' => ['/{$this->mid}/{$this->controller}/create']],
];
?>
EOF;
?>

<div class="page-header">
    <h1>
        <?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', '{$label}'); ?>\n"; ?>
        <small><?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', 'управление'); ?>"; ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', 'Поиск {$this->mrod}');?>\n"; ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php echo <<<EOF
    <?php Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function () {
            $.fn.yiiGridView.update('{$this->class2id($this->modelClass)}-grid', {
                data: $(this).serialize()
            });

            return false;
        });
    ");
    \$this->renderPartial('_search', ['model' => \$model]);
?>\n
EOF;
    ?>
</div>

<br/>

<p> <?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', 'В данном разделе представлены средства управления {$this->mtvor}'); ?>\n"; ?></p>

<?php echo "<?php\n"; ?> $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => '<?php echo $this->class2id($this->modelClass); ?>-grid',
        'type'         => 'striped condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
    if (++$count == 7 || $count >= 7) {
        echo "//";
    }
    echo "            '" . $column->name . "',\n";
}
?>
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
