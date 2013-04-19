<?php
/**
 * Файл отображения для default/index:
 *
 * @category YupeViews
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
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

$this->breadcrumbs=array(
    Yii::t('DocsModule.docs', 'Документация')
);

$fileList = $this->module->fileList(str_replace('{module}', '*', Yii::getPathOfAlias($this->module->moduleDocFolder)) . DIRECTORY_SEPARATOR . Yii::app()->language);
Yii::app()->user->setFlash('info', Yii::t('DocsModule.docs', 'Данный модуль предназначен для документирования проекта.'));

$this->widget(
    'bootstrap.widgets.TbAlert', array(
        'block'  =>true,
        'alerts' =>array(
            'info' => array('block' => true),
        ),
    )
); ?>

<div class="accordion" id="accordion2">
<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
            <?php echo Yii::t('DocsModule.docs', 'Существующие файлы') . ' (' . count($fileList) . ')'; ?>
            </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse in">
            <div class="accordion-inner">
                <ol>
                    <?php
                    array_walk(
                        $fileList, function ($item, $key) {
                            echo CHtml::tag('li', array(), $item);
                        }
                    ); ?>
                </ol>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>