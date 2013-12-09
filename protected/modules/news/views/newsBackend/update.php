<?php
    $this->breadcrumbs = array(        
        Yii::t('NewsModule.news', 'News') => array('/news/newsBackend/index'),
        $model->title => array('/news/newsBackend/view', 'id' => $model->id),
        Yii::t('NewsModule.news', 'Edit'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'News - edit');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'News management'), 'url' => array('/news/newsBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Create article'), 'url' => array('/news/newsBackend/create')),
        array('label' => Yii::t('NewsModule.news', 'News Article') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('NewsModule.news', 'Edit news article'), 'url' => array(
            '/news/newsBackend/update/',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('NewsModule.news', 'View news article'), 'url' => array(
            '/news/newsBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('NewsModule.news', 'Remove news'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/news/newsBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('NewsModule.news', 'Do you really want to remove the article?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Edit news article'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'languages' => $languages, 'langModels' => $langModels)); ?>
