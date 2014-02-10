<?php
$this->pageTitle = Yii::t('UserModule.user','Users');
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog','Blogs') => array('/blog/blog/index'),
    $blog->name => array('/blog/blog/show', 'slug' => $blog->slug),
    Yii::t('UserModule.user','Users'),
);
?>

    <h1><?php echo Yii::t('BlogModule.blog','Members of "{blog}" blog', array('{blog}' => $blog->name)); ?></h1>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'method'      => 'get',
    'type'        => 'vertical'
));
?>

<?php $this->endWidget(); ?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $members->search(),
    'type'     => 'condensed striped',
    'template' => "{items}\n{pager}",
    'columns'  => array(
        array(
            'header' => false,
            'value'  => 'CHtml::link(CHtml::image($data->user->getAvatar(90)), array("/user/people/userInfo","username" => $data->user->nick_name))',
            'type'   => 'html'
        ),
        array(
            'name'   => 'nick_name',
            'header' => 'Пользователь',
            'type'   => 'html',
            'value'  => 'CHtml::link($data->user->nick_name, array("/user/people/userInfo","username" => $data->user->nick_name))'
        ),
        array(
            'name'   => 'location',
            'header' => 'Откуда'
        ),
        array(
            'header' => 'Был на сайте',
            'name'   => 'last_visit',
            'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->user->last_visit, "long", false)'
        ),
        array(
            'header' => 'Присоеденился',
            'name'   => 'registration_date',
            'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->user->registration_date, "long", false)'
        )
    )
));
?>