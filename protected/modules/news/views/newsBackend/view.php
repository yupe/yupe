<?php
$this->breadcrumbs = array(
    Yii::t('NewsModule.news', 'News') => array('/news/newsBackend/index'),
    $model->title,
);

$this->pageTitle = Yii::t('NewsModule.news', 'News - show');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('NewsModule.news', 'News management'),
        'url'   => array('/news/newsBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('NewsModule.news', 'Create article'),
        'url'   => array('/news/newsBackend/create')
    ),
    array('label' => Yii::t('NewsModule.news', 'News Article') . ' «' . mb_substr($model->title, 0, 32) . '»'),
    array(
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('NewsModule.news', 'Edit news article'),
        'url'   => array(
            '/news/newsBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('NewsModule.news', 'View news article'),
        'url'   => array(
            '/news/newsBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('NewsModule.news', 'Remove news'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/news/newsBackend/delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('NewsModule.news', 'Do you really want to remove the article?'),
            'csrf'    => true,
        )
    ),
);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Show news article'); ?><br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<ul class="nav nav-tabs">
    <li class="active"><a href="#anounce" data-toggle="tab"><?php echo Yii::t(
                'NewsModule.news',
                'Short news article example'
            ); ?></a></li>
    <li><a href="#full" data-toggle="tab"><?php echo Yii::t('NewsModule.news', 'Full news article example'); ?></a></li>
</ul>
<div class="tab-content">
    <div id="anounce" class="tab-pane fade active in">
        <div style="margin-bottom: 20px;">
            <h6>
                <span class="label label-info"><?php echo $model->date; ?></span>
                <?php echo CHtml::link($model->title, array('/news/news/show', 'alias' => $model->alias)); ?>
            </h6>

            <p>
                <?php echo $model->short_text; ?>
            </p>
            <i class="fa fa-fw fa-globe"></i><?php echo CHtml::link(
                $model->getPermaLink(),
                $model->getPermaLink()
            ); ?>
        </div>
    </div>
    <div id="full" class="tab-pane fade">
        <div style="margin-bottom: 20px;">
            <h3><?php echo CHtml::link(
                    CHtml::encode($model->title),
                    array('/news/news/show', 'alias' => $model->alias)
                ); ?></h3>
            <?php if ($model->image): { ?>
                <?php echo CHtml::image($model->getImageUrl(), $model->title); ?>
            <?php } endif; ?>
            <p><?php echo $model->full_text; ?></p>
            <span class="label label-info"><?php echo $model->date; ?></span>
            <i class="fa fa-fw fa-user"></i><?php echo CHtml::link(
                $model->user->fullName,
                array('/user/people/' . $model->user->nick_name)
            ); ?>
            <i class="fa fa-fw fa-globe"></i><?php echo CHtml::link(
                $model->getPermaLink(),
                $model->getPermaLink()
            ); ?>
        </div>
    </div>
</div>
