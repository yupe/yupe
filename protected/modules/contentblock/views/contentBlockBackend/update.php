<?php
$this->breadcrumbs = array(
    Yii::t('ContentBlockModule.contentblock', 'Content blocks') => array('/contentblock/contentBlockBackend/index'),
    $model->name                                                => array(
        '/contentblock/contentBlockBackend/view',
        'id' => $model->id
    ),
    Yii::t('ContentBlockModule.contentblock', 'Edit content block'),
);

$this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - edit');

$this->menu = array(
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks administration'),
        'url'   => array('/contentblock/contentBlockBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Add content block'),
        'url'   => array('/contentblock/contentBlockBackend/create')
    ),
    array(
        'label' => Yii::t('ContentBlockModule.contentblock', 'Content block') . ' «' . mb_substr(
                $model->name,
                0,
                32
            ) . '»'
    ),
    array(
        'icon'  => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Edit content block'),
        'url'   => array(
            '/contentblock/contentBlockBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('ContentBlockModule.contentblock', 'View content block'),
        'url'   => array(
            '/contentblock/contentBlockBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'glyphicon glyphicon-trash',
        'label'       => Yii::t('ContentBlockModule.contentblock', 'Remove Content block'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/contentblock/contentBlockBackend/delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('ContentBlockModule.contentblock', 'Do you really want to remove content block?'),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Edit content block'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
