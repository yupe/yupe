<?php
/**
 * @var $this BlogController
 * @var $form TbActiveForm
 * @var $blogs Blog
 */
$this->title = [Yii::t('BlogModule.blog', 'Blogs'), Yii::app()->getModule('yupe')->siteName];
$this->metaDescription = Yii::t('BlogModule.blog', 'Blogs');
$this->metaKeywords = Yii::t('BlogModule.blog', 'Blogs');
?>

<?php $this->breadcrumbs = [Yii::t('BlogModule.blog', 'Blogs')]; ?>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'method' => 'get',
        'type'   => 'vertical'
    ]
);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <?= $form->textField(
                $blogs,
                'name',
                ['placeholder' => Yii::t('BlogModule.blog', 'Search by blog name'), 'class' => 'form-control']
            ); ?>
            <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?= Yii::t('BlogModule.blog', 'search'); ?></button>
      </span>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<h1>
    <small>
        <?= Yii::t('BlogModule.blog', 'Blogs'); ?> <a
            href="<?= Yii::app()->createUrl('/blog/blogRss/feed/'); ?>"><img
                src="<?= Yii::app()->getTheme()->getAssetsUrl() . "/images/rss.png"; ?>"
                alt="<?= Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"
                title="<?= Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"></a>
    </small>
</h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider'       => $blogs->search(),
        'template'           => '{sorter}<br/><hr/>{items} {pager}',
        'sorterCssClass'     => 'sorter pull-left',
        'itemView'           => '_item',
        'ajaxUpdate'         => false,
        'sortableAttributes' => [
            'name',
            'postsCount',
            'membersCount'
        ],
    ]
);
?>
