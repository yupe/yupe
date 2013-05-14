<?php
    $this->breadcrumbs = array(
        $this->getModule('news')->getCategory() => array(''),
        Yii::t('NewsModule.news', 'Новости') => array('/news/default/index'),
        $model->title,
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'Новости - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'Управление новостями'), 'url' => array('/news/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Добавить новость'), 'url' => array('/news/default/create')),
        array('label' => Yii::t('NewsModule.news', 'Новость') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('NewsModule.news', 'Редактирование новости'), 'url' => array(
            '/news/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('NewsModule.news', 'Просмотреть новость'), 'url' => array(
            '/news/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('NewsModule.news', 'Удалить новость'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/news/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('NewsModule.news', 'Вы уверены, что хотите удалить новость?'),
            'csrf' => true,
        )),
    );
?>

<div class="page-header">
     <h1>
         <?php echo Yii::t('NewsModule.news', 'Просмотр новости'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
     </h1>
</div>

<ul class="nav nav-tabs">
    <li class="active"><a href="#anounce" data-toggle="tab"><?php echo Yii::t('NewsModule.news', 'Пример краткой версии новости'); ?></a></li>
    <li><a href="#full" data-toggle="tab"><?php echo Yii::t('NewsModule.news', 'Пример полной версии новости'); ?></a></li>
</ul>
<div class="tab-content">
    <div id="anounce" class="tab-pane fade active in">
        <div style="margin-bottom: 20px;">
            <h6>
                <span class="label"><?php echo $model->date; ?></span> 
                <?php echo CHtml::link($model->title, array('/news/news/show', 'title' => $model->alias)); ?>
            </h6>
            <p>
                <?php echo $model->short_text; ?>
            </p>
            <i class="icon-globe"></i> <?php echo $model->getPermaLink(); ?>
        </div>
    </div>
    <div id="full"  class="tab-pane fade">
        <div style="margin-bottom: 20px;">
            <h3><?php echo CHtml::link($model->title, array('/news/news/show', 'title' => $model->alias)); ?></h3>
            <p><?php echo $model->full_text; ?></p>
            <span class="label"><?php echo $model->date; ?></span>
            <i class="icon-user"></i><?php echo CHtml::link($model->user->fullName, array('/user/people/' . $model->user->nick_name)); ?>
            <i class="icon-globe"></i> <?php echo $model->getPermaLink(); ?>
        </div>
    </div>
</div>
