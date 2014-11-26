<?php
/**
 * Файл отображения для default/index:
 *
 * @category YupeViews
 * @package  yupe
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

/**
 * Добавляем нужный CSS:
 */
Yii::app()->clientScript->registerCssFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.docs.views.assets') . '/css/docs.css'
    )
);

$this->breadcrumbs = [
    Yii::t('DocsModule.docs', 'Documentation')
];

$fileList = $this->module->fileList(
    str_replace('{module}', '*', Yii::getPathOfAlias($this->module->moduleDocFolder)) . DIRECTORY_SEPARATOR . Yii::app(
    )->language
);
Yii::app()->user->setFlash('info', Yii::t('DocsModule.docs', 'Module for project documentation'));

$this->widget('bootstrap.widgets.TbAlert');
?>

<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <?php echo Yii::t('DocsModule.docs', 'Existing files') . ' (' . count($fileList) . ')'; ?>
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <ol>
                    <?php
                    array_walk(
                        $fileList,
                        function ($item, $key) {
                            echo CHtml::tag('li', [], $item);
                        }
                    ); ?>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
