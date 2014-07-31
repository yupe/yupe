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
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->mb_ucfirst($this->mim);
$labelIm = $this->mb_ucfirst($this->im);

echo <<<EOF
<?php
/**
 * Отображение для update:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    \$this->breadcrumbs = array(
        Yii::app()->getModule('{$this->mid}')->getCategory() => array(),
        Yii::t('{$this->mid}', '$label') => array('/{$this->mid}/{$this->controller}/index'),
        \$model->{$nameColumn} => array('/{$this->mid}/{$this->controller}/view', 'id' => \$model->{$this->tableSchema->primaryKey}),
        Yii::t('{$this->mid}', 'Редактирование'),
    );

    \$this->pageTitle = Yii::t('{$this->mid}', '{$label} - редактирование');

    \$this->menu = array(
        array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('{$this->mid}', 'Управление {$this->mtvor}'), 'url' => array('/{$this->mid}/{$this->controller}Backend/index')),
        array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('{$this->mid}', 'Добавить {$this->vin}'), 'url' => array('/{$this->mid}/{$this->controller}Backend/create')),
        array('label' => Yii::t('{$this->mid}', '{$labelIm}') . ' «' . mb_substr(\$model->{$this->tableSchema->primaryKey}, 0, 32) . '»'),
        array('icon' => 'glyphicon glyphicon-pencil', 'label' => Yii::t('{$this->mid}', 'Редактирование {$this->rod}'), 'url' => array(
            '/{$this->mid}/{$this->controller}Backend/update',
            'id' => \$model->{$this->tableSchema->primaryKey}
        )),
        array('icon' => 'glyphicon glyphicon-eye-open', 'label' => Yii::t('{$this->mid}', 'Просмотреть {$this->vin}'), 'url' => array(
            '/{$this->mid}/{$this->controller}Backend/view',
            'id' => \$model->{$this->tableSchema->primaryKey}
        )),
        array('icon' => 'glyphicon glyphicon-trash', 'label' => Yii::t('{$this->mid}', 'Удалить {$this->vin}'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/{$this->mid}/{$this->controller}Backend/delete', 'id' => \$model->{$this->tableSchema->primaryKey}),
            'confirm' => Yii::t('{$this->mid}', 'Вы уверены, что хотите удалить {$this->vin}?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
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
