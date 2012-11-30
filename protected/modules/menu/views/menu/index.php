<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('menu')->getCategory() => array(),
        Yii::t('menu', 'Меню') => array('/menu/menu/index'),
        Yii::t('menu', 'Управление')
    );

    $this->pageTitle = Yii::t('menu', 'Меню - управление');

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
        <?php echo Yii::t('menu', 'Меню'); ?> 
        <small><?php echo Yii::t('menu', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('menu', 'Поиск меню'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('menu-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

</br>

<p><?php echo Yii::t('menu', 'В данном разделе представлены средства управления меню'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'menu-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'name',
        'code',
        'description',
        array(
            'header' => Yii::t('menu', 'Пунктов'),
            'value'  => 'count($data->menuItems)',
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("lock", "ok-sign"))',
        ),
        array(
            'class'    => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}{update}{delete}{add}',
            'buttons'  => array(
                'add' => array(
                    'label'   => false,
                    'url'     => 'Yii::app()->createUrl("/menu/menuitem/create", array("mid" => $data->id))',
                    'options' => array(
                        'class' => 'icon-plus-sign',
                        'title' => Yii::t('menu', 'Добавить пункт меню'),
                    ),
                ),
            ),
        ),
    ),
)); ?>