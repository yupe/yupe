<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('comment')->getCategory() => array(),
        Yii::t('CommentModule.comment', 'Комментарии') => array('/comment/default/index'),
        Yii::t('CommentModule.comment', 'Управление'),
    );

    $this->pageTitle = Yii::t('CommentModule.comment', 'Комментарии - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Список комментариев'), 'url' => array('/comment/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CommentModule.comment', 'Добавить комментарий'), 'url' => array('/comment/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Комментарии'); ?>
        <small><?php echo Yii::t('CommentModule.comment', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('CommentModule.comment', 'Поиск комментариев'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('comment-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('CommentModule.comment', 'В данном разделе представлены средства управления комментариями'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'comment-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'bulkActions'      => array(
        /* Массив кнопок действий: */
        'actionButtons' => array(
            array(
                'id'         => 'delete-comment',
                'buttonType' => 'button',
                'type'       => 'danger',
                'size'       => 'small',
                'label'      => Yii::t('CommentModule.comment', 'Удалить'),
                /**
                 *   Логика следующая - получаем массив выбранных эллементов в переменную values,
                 *   далее передаём в функцию multiaction - необходимое действие и эллементы.
                 *   Multiaction - делает ajax-запрос на actionMultiaction, где уже происходит
                 *   обработка данных (указывая собственные действия - необходимо создавать их
                 *   обработчики в actionMultiaction):
                 **/
                'click'      => 'js:function(values){ if(!confirm("' . Yii::t('CommentModule.comment', 'Вы уверены, что хотите удалить выбранные элементы?') . '")) return false; multiaction("delete", values); }',
            ),
        ),

        // if grid doesn't have a checkbox column type, it will attach
        // one and this configuration will be part of it
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),
    'columns'      => array(
        'id',
        'model',
        'model_id',
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("pencil", "ok-sign", "fire", "remove"))',
        ),
        'text',
        array(
            'name'  => 'creation_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
        ),
        'name',
        'email',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>