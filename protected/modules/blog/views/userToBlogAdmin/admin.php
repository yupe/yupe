<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('blogAdmin/admin'),
        Yii::t('blog', 'Участники')=>array('admin'),
        Yii::t('blog', 'Управление'),
    );
    
    $this->menu=array(
        array('label'=>Yii::t('blog', 'Список участников'), 'url'=>array('index')),
        array('label'=>Yii::t('blog', 'Добавить участника'), 'url'=>array('create')),
    );

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function() {
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function() {
            $.fn.yiiGridView.update('user-to-blog-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<h1><?php echo $this->module->getName(); ?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('blog','Поиск'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
    $this->widget('YCustomGridView', array(
        'id'=>'user-to-blog-grid',
        'dataProvider'=>$model->search(),    
        'columns'=>array(
            'id',
            array(
                'name'=>'user_id',
                'type' => 'raw',
                'value' => 'CHtml::link($data->user->getFullName(),array("/user/default/view/","id" => $data->user->id))'
            ),
            array(
                'name'  => 'blog_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->blog->name,array("/blog/blogAdmin/view/","id" => $data->blog->id))'
            ),
            'create_date',
            'update_date',
            array(
                 'name'=>'role',
                 'value'=>'$data->getRole()'
            ),
            array(
                'name'=>'status',
                'type'=>'raw',
                'value'=>'$this->grid->returnStatusHtml($data)'
            ),
            'note',
            array(
                'class'=>'CButtonColumn',
            ),
        ),
    ));
?>
