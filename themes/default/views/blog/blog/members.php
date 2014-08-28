<?php
$this->pageTitle = Yii::t('UserModule.user', 'Users');
$this->description = Yii::t(
    'BlogModule.blog',
    'Members of "{blog}" blog',
    array('{blog}' => CHtml::encode($blog->name))
);
$this->keywords = Yii::t('BlogModule.blog', 'Members');
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index'),
    CHtml::encode($blog->name)         => array('/blog/blog/show', 'slug' => CHtml::encode($blog->slug)),
    Yii::t('UserModule.user', 'Users'),
);
?>

<h1><?php echo Yii::t(
        'BlogModule.blog',
        'Members of "{blog}" blog',
        array('{blog}' => CHtml::encode($blog->name))
    ); ?></h1>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'method' => 'get',
        'type'   => 'vertical'
    )
);
?>

<?php $this->endWidget(); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbGridView',
    array(
        'dataProvider' => $members->search(),
        'type'         => 'condensed striped',
        'template'     => "{items}\n{pager}",
        'columns'      => array(
            array(
                'header' => false,
                'value'  => 'CHtml::link(CHtml::image($data->user->getAvatar(90)), array("/user/people/userInfo","username" => $data->user->nick_name))',
                'type'   => 'html'
            ),
            array(
                'name'   => 'nick_name',
                'header' => Yii::t('BlogModule.blog', 'User'),
                'type'   => 'html',
                'value'  => 'CHtml::link($data->user->nick_name, array("/user/people/userInfo","username" => $data->user->nick_name))'
            ),
            array(
                'name'   => 'location',
                'header' => Yii::t('BlogModule.blog', 'location')
            ),
            array(
                'header' => Yii::t('BlogModule.blog', 'Last visit'),
                'name'   => 'last_visit',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->user->last_visit, "long", false)'
            ),
            array(
                'header' => Yii::t('BlogModule.blog', 'Joined'),
                'name'   => 'registration_date',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->user->registration_date, "long", false)'
            )
        )
    )
);
?>
