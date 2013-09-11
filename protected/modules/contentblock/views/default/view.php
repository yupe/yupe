<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contentblock')->getCategory() => array(),
        Yii::t('ContentBlockModule.contentblock', 'Content blocks') => array('/contentblock/default/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - view');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks administration'), 'url' => array('/contentblock/default/index')),
        array('icon' => 'plus-sign','label' => Yii::t('ContentBlockModule.contentblock', 'Add new content block'), 'url' => array('/contentblock/default/create')),
        array('label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ContentBlockModule.contentblock', 'Edit content block'), 'url' => array(
            '/contentblock/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ContentBlockModule.contentblock', 'View content block'), 'url' => array(
            '/contentblock/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ContentBlockModule.contentblock', 'Remove content block'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/contentblock/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('ContentBlockModule.contentblock', 'Are you sure you want to delete content block?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'View content block'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
        'code',
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        'content',
        'description',
    ),
)); ?>

<br />
<div>
    <?php echo Yii::t('ContentBlockModule.contentblock', 'Shortcode for using this block in template:'); ?>
    <br /><br />
    <?php echo $example; ?>
</div>
