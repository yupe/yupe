<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('admin'),
        Yii::t('blog', 'Управление'),
    );

    $this->menu = array(
        array('label' => Yii::t('blog', 'Блоги')),
        array('icon' => 'th-large white', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/blogAdmin/admin/')),
        array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список блогов'), 'url' => array('/blog/blogAdmin/index/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/blogAdmin/create/')),

        array('label' => Yii::t('blog', 'Записи')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление записями'), 'url' => array('/blog/postAdmin/admin/')),
        array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список записей'), 'url' => array('/blog/postAdmin/index/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/postAdmin/create/')),

        array('label' => Yii::t('blog', 'Участники')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/userToBlogAdmin/admin/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/userToBlogAdmin/create/')),
    );

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function() {
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function() {
            $.fn.yiiGridView.update('blog-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<h1><?php echo $this->module->getName(); ?></h1>

<?php echo CHtml::link(Yii::t('blog', 'Поиск'), '#', array('class'=>'search-button')); ?>

<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
    $this->widget('YCustomGridView', array(
        'id'            => 'blog-grid',
        'dataProvider'  => $model->search(),
        'itemsCssClass' => ' table table-condensed',
        'columns'       => array(
            'id',
            array(
                'name'  => 'name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->name, array("/blog/blogAdmin/update/", "id" => $data->id))',
            ),
            array(
                'name'  => Yii::t('blog','Записей'),
                'value' => '$data->postsCount',
            ),
            array(
                'name'  => Yii::t('blog','Участников'),
                'value' => '$data->membersCount',
            ),
            'icon',
            'slug',
            array(
                'name'  => 'type',
                'value' => '$data->getType()',
            ),
            array(
                'name'  => 'status',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data)',
            ),
            array(
                'name'  => 'create_user_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->createUser->getFullName(), array("/user/default/view/", "id" => $data->createUser->id))',
            ),
            array(
                'name'  => 'update_user_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->updateUser->getFullName(), array("/user/default/view/", "id" => $data->updateUser->id))',
            ),
            'create_date',
            'update_date',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    ));
?>
