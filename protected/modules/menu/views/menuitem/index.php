<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('menu')->getCategory() => array(),
        Yii::t('menu', 'Меню') => array('/menu/menu/index'),
        Yii::t('menu', 'Пункты меню'),
    );

    $this->pageTitle = Yii::t('menu', 'Пункты меню - управление');

    $this->menu = array(
        array('label' => Yii::t('menu', 'Меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
        )),
        array('label' => Yii::t('menu', 'Пункты меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('menu', 'Пункты меню'); ?> 
        <small><?php echo Yii::t('menu', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('menu', 'Поиск пунктов меню'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('blog-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

</br>

<p><?php echo Yii::t('menu', 'В данном разделе представлены средства управления пунктами меню'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'menu-items-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'title',
        'href',
        array(
            'name'  => 'menu_id',
            'value' => '$data->menu->name',
        ),
        // @TODO Обратить внимание, возможно сделать иначе определение корня
        array(
            'name'  => 'parent_id',
            'value' => '$data->parent',
        ),
        array(
            'name'  => 'condition_name',
            'value' => '$data->conditionName',
        ),
        array(
            'name'  => 'sort',
            'type'  => 'raw',
            'value' => '$this->grid->getUpDownButtons($data)',
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("lock", "ok-sign"))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>