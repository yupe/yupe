<?php
/* @var $this DefaultController */

$this->breadcrumbs = [
    Yii::t('ZendSearchModule.zendsearch', 'Find (Zend)') => ['/zendsearch/manageBackend/index'],
    Yii::t('ZendSearchModule.zendsearch', 'Manage'),
];

$this->pageTitle = Yii::t('ZendSearchModule.zendsearch', 'Find (Zend) - manage');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ZendSearchModule.zendsearch', 'Find (Zend)'); ?>
        <small><?php echo Yii::t('ZendSearchModule.zendsearch', 'manage'); ?></small>
    </h1>
</div>
<p>
    <?php echo Yii::t(
        'ZendSearchModule.zendsearch',
        'Models you want to index is necessary to describe in configuration file.'
    ); ?><br/>
    <?php echo Yii::t('ZendSearchModule.zendsearch', 'For index creation, please click button below.'); ?>
</p>
<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'ajaxButton',
        'id'          => 'create-search',
        'context'     => 'primary',
        'label'       => Yii::t('ZendSearchModule.zendsearch', 'Update find index'),
        'loadingText' => Yii::t('ZendSearchModule.zendsearch', 'Index is updating... Wait please...'),
        'size'        => 'large',
        'url'         => $this->createUrl('/zendsearch/manageBackend/create'),
        'ajaxOptions' => [
            'type'       => 'POST',
            'data'       => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'url'        => $this->createUrl('/zendsearch/manageBackend/create'),
            'beforeSend' => 'function () {
	       $("#create-search").text("' . Yii::t('ZendSearchModule.zendsearch', 'Wait please...') . '");
	     }',
            'success'    => 'js:function (data,status) {
            $("#create-search").text("' . Yii::t('ZendSearchModule.zendsearch', 'Update find index') . '");
            alert(data);
	     }',
        ]
    ]
);
?>
