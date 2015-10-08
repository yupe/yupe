<?php
/**
 * @var $this BlogController
 * @var $form TbActiveForm
 * @var $blog Blog
 */

$this->title = Yii::t('UserModule.user', 'Users');
$this->metaDescription = Yii::t('BlogModule.blog', 'Members of "{blog}" blog', ['{blog}' => CHtml::encode($blog->name)]);
$this->metaKeywords = Yii::t('BlogModule.blog', 'Members');
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index'],
    CHtml::encode($blog->name)         => ['/blog/blog/view', 'slug' => CHtml::encode($blog->slug)],
    Yii::t('UserModule.user', 'Users'),
];
?>

<h1><?= Yii::t(
        'BlogModule.blog',
        'Members of "{blog}" blog',
        ['{blog}' => CHtml::encode($blog->name)]
    ); ?></h1>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'method' => 'get',
        'type'   => 'vertical'
    ]
);
?>

<?php $this->endWidget(); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbGridView',
    [
        'dataProvider' => $members->search(),
        'type'         => 'condensed striped',
        'template'     => "{items}\n{pager}",
        'columns'      => [
            [
                'header' => false,
                'value'  => 'CHtml::link(CHtml::image($data->user->getAvatar(90), $data->user->getFullName(), array("width" => 90, "height" => 90)), array("/user/people/userInfo","username" => $data->user->nick_name))',
                'type'   => 'html'
            ],
            [
                'name'   => 'nick_name',
                'header' => Yii::t('BlogModule.blog', 'User'),
                'type'   => 'html',
                'value'  => 'CHtml::link($data->user->nick_name, array("/user/people/userInfo","username" => $data->user->nick_name))'
            ],
            [
                'name'   => 'location',
                'header' => Yii::t('BlogModule.blog', 'location')
            ],
            [
                'header' => Yii::t('BlogModule.blog', 'Last visit'),
                'name'   => 'visit_time',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->user->visit_time, "long", false)'
            ],
            [
                'header' => Yii::t('BlogModule.blog', 'Joined'),
                'name'   => 'create_time',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->user->create_time, "long", false)'
            ]
        ]
    ]
);
?>
