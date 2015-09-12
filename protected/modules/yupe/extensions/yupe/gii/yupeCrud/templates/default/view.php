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
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->mb_ucfirst($this->mim);
$labelIm = $this->mb_ucfirst($this->im);

echo <<<EOF
<?php
/**
 * Отображение для view:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
\$this->breadcrumbs = [
    \$this->getModule()->getCategory() => [],
    Yii::t('{$this->getModuleTranslate()}', '$label') => ['/{$this->mid}/{$this->controller}/index'],
    \$model->{$nameColumn},
];

\$this->pageTitle = Yii::t('{$this->getModuleTranslate()}', '{$label} - просмотр');

\$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('{$this->getModuleTranslate()}', 'Управление {$this->mtvor}'), 'url' => ['/{$this->mid}/{$this->controller}/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('{$this->getModuleTranslate()}', 'Добавить {$this->vin}'), 'url' => ['/{$this->mid}/{$this->controller}/create']],
    ['label' => Yii::t('{$this->getModuleTranslate()}', '{$labelIm}') . ' «' . mb_substr(\$model->{$this->tableSchema->primaryKey}, 0, 32) . '»'],
    ['icon' => 'fa fa-fw fa-pencil', 'label' => Yii::t('{$this->getModuleTranslate()}', 'Редактирование {$this->rod}'), 'url' => [
        '/{$this->mid}/{$this->controller}/update',
        'id' => \$model->{$this->tableSchema->primaryKey}
    ]],
    ['icon' => 'fa fa-fw fa-eye', 'label' => Yii::t('{$this->getModuleTranslate()}', 'Просмотреть {$this->vin}'), 'url' => [
        '/{$this->mid}/{$this->controller}/view',
        'id' => \$model->{$this->tableSchema->primaryKey}
    ]],
    ['icon' => 'fa fa-fw fa-trash-o', 'label' => Yii::t('{$this->getModuleTranslate()}', 'Удалить {$this->vin}'), 'url' => '#', 'linkOptions' => [
        'submit' => ['/{$this->mid}/{$this->controller}/delete', 'id' => \$model->{$this->tableSchema->primaryKey}],
        'confirm' => Yii::t('{$this->getModuleTranslate()}', 'Вы уверены, что хотите удалить {$this->vin}?'),
        'csrf' => true,
    ]],
];
?>
EOF;
?>

<div class="page-header">
    <h1>
        <?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', 'Просмотр') . ' ' . Yii::t('{$this->getModuleTranslate()}', '{$this->rod}'); ?>"; ?>
        <br/>
        <small>&laquo;<?php echo "<?php echo \$model->{$nameColumn}; ?>"; ?>&raquo;</small>
    </h1>
</div>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbDetailView', [
    'data'       => $model,
    'attributes' => [
<?php
    foreach ($this->tableSchema->columns as $column) {
    echo "        '{$column->name}',\n";
    }
    ?>
    ],
]); ?>
