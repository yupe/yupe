<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/admin')),
    array('icon' => 'th-list white', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('/news/default/index')),
    array('icon' => 'file', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('news', 'Новости');?>
    <small>как анонсы</small>
    </h1>
</div>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
