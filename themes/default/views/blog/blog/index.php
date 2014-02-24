<?php
    $this->pageTitle   = Yii::t('BlogModule.blog', 'Blogs');
    $this->description = Yii::t('BlogModule.blog', 'Blogs');
    $this->keywords    = Yii::t('BlogModule.blog', 'Blogs');
?>

<?php $this->breadcrumbs = array(Yii::t('BlogModule.blog', 'Blogs')); ?>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'method' => 'get',
        'type' => 'vertical'
    )
);
?>

    <div class="input-append">
        <?php echo $form->textField(
            $blogs,
            'name',
            array('placeholder' => Yii::t('BlogModule.blog', 'Search by blog name'), 'class' => 'span8')
        ); ?>
        <button class="btn" type="submit"><?php echo Yii::t('BlogModule.blog', 'search'); ?></button>
    </div>

<?php $this->endWidget(); ?>

    <h1>
        <small>
            <?php echo Yii::t('BlogModule.blog', 'Blogs'); ?> <a
                href="<?php echo Yii::app()->createUrl('/blog/blogRss/feed/'); ?>"><img
                    src="<?php echo Yii::app()->AssetManager->publish(
                        Yii::app()->theme->basePath . "/web/images/rss.png"
                    ); ?>" alt="<?php echo Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"
                    title="<?php echo Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"></a>
        </small>
    </h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $blogs->search(),
        'template' => '{sorter}<br/><hr/>{items} {pager}',
        'sorterCssClass' => 'sorter pull-left',
        'itemView' => '_view',
        'ajaxUpdate' => false,
        'sortableAttributes' => array(
            'name',
            'postsCount',
            'membersCount'
        ),
    )
);
?>