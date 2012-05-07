<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    $model->title,
);

$this->menu = array(
    array('encodeLabel'=> false, 'label' => '<i class="icon-list"></i>'.Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/admin')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-file"></i>'.Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-pencil"></i>'.Yii::t('news', 'Редактировать эту новость'), 'url' => array('/news/default/update','id'=> $model-> id)),
    array('encodeLabel'=> false, 'label' => '<i class="icon-eye-open icon-white"></i>'.Yii::t('news', 'Просмотр новости')."<br /><span class='label' style='font-size: 80%; margin-left:17px;'>".mb_substr($model-> title,0,32)."</span>", 'url' => array('/news/default/view','id'=> $model-> id)),
    array('encodeLabel'=> false, 'label' => '<i class="icon-remove"></i>'.Yii::t('news', 'Удалить эту новость'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
);
?>

<div class="page-header"><h1><?php echo Yii::t('news', 'Просмотр новости');?>
    <br /><small>&laquo;<?php echo $model->title; ?>&raquo;</small></h1></div>
<ul class="nav nav-tabs">
    <li class="active"><a href="#anounce" data-toggle="tab"><?=Yii::t('news','Пример краткой версии новости')?></a></li>
    <li><a href="#full" data-toggle="tab"><?=Yii::t('news','Пример полной версии новости')?></a></li>
</ul>
<div class="tab-content">
    <div id="anounce" class="tab-pane fade active in">
    <?php for ( $i=0; $i<3; $i++ ) { ?>
        <div style="margin-bottom: 20px;">
            <h6><span class="label"><?=$model->date;?></span> <?=CHtml::link($model->title, array('/news/news/show', 'title' => $model->alias))?></h6>
            <p>
                <?=$model->short_text; ?>
            </p>
        </div>
    <?php } ?>
    </div>
    <div id="full"  class="tab-pane fade">
        <div style="margin-bottom: 20px;">
            <h3><?=CHtml::link($model->title, array('/news/news/show', 'title' => $model->alias))?></h3>
            <p>
                <?=$model->full_text; ?>
            </p>
            <span class="label"><?=$model->date;?></span>
            <i class="icon-user"></i><?=CHtml::link($model->user->fullName,array('/user/people/'.$model->user->nick_name));?>
        </div>
    </div>
</div>

<?php /* $this->widget('bootstrap.widgets.BootDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        array(
                                                            'name' => 'creation_date',
                                                             'value' => Yii::app()->dateFormatter->formatDateTime($model->creation_date,'short'),
                                                        ),
                                                        array(
                                                            'name' => 'change_date',
                                                            'value' => Yii::app()->dateFormatter->formatDateTime($model->creation_date,'short'),
                                                        ),
                                                        'date',
                                                        'title',
                                                        'alias',
                                                        'short_text',
//                                                        'full_text',
                                                        array(
                                                            'name' => 'user_id',
                                                            'value' => $model->user->getFullName()
                                                        ),
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                        array(
                                                            'name' => 'is_protected',
                                                            'value' => $model->getProtectedStatus()
                                                        ),

                                                    ),
                                               )); */?>

