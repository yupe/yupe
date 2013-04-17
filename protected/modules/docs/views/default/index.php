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

$this->breadcrumbs=array(
    Yii::t('DocsModule.docs', 'Документация')
);

echo CHtml::tag(
    'p', array('class' => 'alert alert-info'), 
    Yii::t('DocsModule.docs', 'Данный модуль предназначен для документирования проекта.')
);

echo CHtml::openTag(
    'div', array(
        'class' => 'accordion',
        'id'    => 'accordion2',
    )
);

$collapse = $this->beginWidget('bootstrap.widgets.TbCollapse');
$fileList = $this->module->fileList(Yii::getPathOfAlias($this->module->docFolder) . DIRECTORY_SEPARATOR . Yii::app()->language);

echo '
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">'
            . Yii::t('DocsModule.docs', 'Существующие файлы') . ' (' . count($fileList) . '):'
            .'</a>
        </div>
        <div id="collapseOne" class="accordion-body collapse in">
            <div class="accordion-inner">';


echo CHtml::openTag('ol');

array_walk(
    $fileList, function ($item, $key) {
        echo CHtml::tag('li', array(), $item);
    }
);

echo CHtml::closeTag('ol');

echo '
            </div>
        </div>
    </div>';

$this->endWidget();

echo CHtml::closeTag('div');