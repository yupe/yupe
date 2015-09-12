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

echo <<<EOF
<?php
/**
 * Отображение для create:
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
    Yii::t('{$this->getModuleTranslate()}', 'Добавление'),
];

\$this->pageTitle = Yii::t('{$this->getModuleTranslate()}', '{$label} - добавление');

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
        <small><?php echo "<?php echo Yii::t('{$this->getModuleTranslate()}', 'добавление'); ?>"; ?></small>
    </h1>
</div>

<?php echo "<?php echo \$this->renderPartial('_form', ['model' => \$model]); ?>"; ?>
