<?php
/**
 * Отображение для index:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs=array(
    $this->module->getCategory() => array('index'),
    Yii::t('MailModule.mail', 'Почтовые события')=>array('index'),
    Yii::t('MailModule.mail', 'Список'),
);
$this->pageTitle = Yii::t('MailModule.mail', 'Список почтовых событий');

$this->menu = array(
    array('label' => Yii::t('MailModule.mail', 'Почтовые события')),
    array('icon'=> 'list-alt white', 'label' => Yii::t('MailModule.mail', 'Список событий'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Добавить событие'), 'url' => array('/mail/eventAdmin/create')),
    array('label' => Yii::t('MailModule.mail', 'Почтовые шаблоны')),
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Список шаблонов'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Добавить шаблон'), 'url' => array('/mail/templateAdmin/create')),
);

Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-button').click(function(){
    	$('.search-form').toggle();
    	return false;
    });
    $('.search-form').submit(function(){
    	$.fn.yiiGridView.update('mail-event-grid', {
    		data: $(this).serialize()
    	});
    	return false;
    });"
);

?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Почтовые события');?> <small><?php echo Yii::t('MailModule.mail', 'управление');?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse" data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#"><?php echo Yii::t('MailModule.mail', 'Поиск почтовых событий');?></a><span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form').submit(function(){       
        $.fn.yiiGridView.update('mail-event-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);

$this->renderPartial('_search', array('model'=>$model));
?>
</div>

<br/>

<p>
    <?php echo Yii::t('MailModule.mail', 'В данном разделе представлены средства управления почтовыми событиями'); ?>
</p>

<?php
$this->widget(
    'application.modules.yupe.components.YCustomGridView', array(
        'id'           => 'mail-event-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            'id',
            'code',
            'name',
            array(
                'header' => Yii::t('MailModule.mail', 'Шаблонов'),
                'type'   => 'raw',
                'value'  => 'CHtml::link(count($data->templates), array("/mail/templateAdmin/index/", "event" => $data->id))',
            ),
            array(
                'header'      => $model->getAttributeLabel('description'),
                'value'       => '$data->shortDescription;',
                'htmlOptions' => array(
                    'style'   => 'width: 20%;'
                ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{view}{update}{delete}{add}',
                'buttons'  => array(
                    'add' => array(
                        'label'   => false,
                        'url'     => 'Yii::app()->createUrl("/mail/templateAdmin/create/", array("eid" => $data->id))',
                        'options' => array(
                            'class' => 'icon-plus-sign',
                            'title' => Yii::t('menu', 'Добавить почтвый шаблон'),
                        )
                    )
                )
            ),
        ),
    )
); ?>