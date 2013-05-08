<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('menu')->getCategory() => array(),
        Yii::t('MenuModule.menu', 'Меню') => array('/menu/menu/index'),
        Yii::t('MenuModule.menu', 'Пункты меню'),
    );

    $this->pageTitle = Yii::t('MenuModule.menu', 'Пункты меню - управление');

    $this->menu = array(
        array('label' => Yii::t('MenuModule.menu', 'Меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
        )),
        array('label' => Yii::t('MenuModule.menu', 'Пункты меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Пункты меню'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('MenuModule.menu', 'Поиск пунктов меню'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('menu-items-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

</br>

<p><?php echo Yii::t('MenuModule.menu', 'В данном разделе представлены средства управления пунктами меню'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'menu-items-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:50px'),
        ),
        'title',
        'href',
        'class',
        'title_attr',
        //'before_link',
        //'after_link',
        //'target',
        //'rel',
        array(
            'name'        => 'menu_id',
            'type'        => 'raw',
            'value'       => 'CHtml::link($data->menu->name, Yii::app()->createUrl("/menu/menu/update", array("id" => $data->menu->id)))',
            'filter'      => CHtml::activeDropDownList($model, 'menu_id', $model->menuList, array('empty' => '')),
            'htmlOptions' => array('style' => 'width:110px'),
        ),
        array(
            'name'   => 'parent_id',
            'value'  => '$data->getParent()',
            'filter' => CHtml::activeDropDownList($model, 'status', $model->parentTree, array('disabled' => ($model->menu_id) ? false : true) + array('encode' => false)),
        ),
        array(
            'name'   => 'condition_name',
            'value'  => '$data->getConditionName()',
            'filter' => $model->getConditionList(),
        ),
        array(
            'name'  => 'sort',
            'type'  => 'raw',
            'value' => '$this->grid->getUpDownButtons($data)',
        ),
        array(
            'name'        => 'status',
            'type'        => 'raw',
            'value'       => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("lock", "ok-sign"))',
            'filter'      => $model->statusList,
            'htmlOptions' => array('style' => 'width:110px'),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>