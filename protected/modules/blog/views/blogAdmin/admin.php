<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('admin'),
        Yii::t('blog', 'Управление'),
    );

    $this->menu = array(
        array('label'=>Yii::t('blog','Список блогов'), 'url'=>array('index')),
        array('label'=>Yii::t('blog','Добавить блог'), 'url'=>array('create')),
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

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('blog', 'Поиск'), '#', array('class'=>'search-button')); ?>

<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
    $this->widget('YCustomGridView', array(
        'id'=>'blog-grid',
        'dataProvider'=>$model->search(),
        'columns'=>array(
            'id',
            'name',
            'icon',
            'slug',
            array(
                'name'=>'type',
                'value'=>'$data->getType()',
            ),
            array(
                'name'=>'status',
                'type'=>'raw',
                'value'=>'$this->grid->returnStatusHtml($data)',
            ),
            array(
                'name'=>'create_user_id',
                'value'=>'$data->createUser->getFullName()',
            ),
            array(
                'name'=>'update_user_id',
                'value'=>'$data->updateUser->getFullName()',
            ),
            array(
                'name'=>'create_date',
                'value'=>'$data->create_date',
            ),
            array(
                'name'=>'update_date',
                'value'=>'$data->update_date',
            ),
            array(
                'class'=>'CButtonColumn',
            ),
        ),
    ));
?>
