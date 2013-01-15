<?php
    $contentblock = Yii::app()->getModule('contentblock');
    $this->breadcrumbs = array(
        $contentblock->getCategory() => array('/yupe/backend/index', 'category' => $contentblock->getCategoryType() ),
        Yii::t('ContentBlockModule.contentblock', 'Блоки контента') => array('/contentblock/defaultAdmin/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('catalog', 'Блоки контента - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('ContentBlockModule.contentblock', 'Управление блоками контента'), 'url' => array('/contentblock/defaultAdmin/index')),
        array('icon' => 'plus-sign','label' => Yii::t('ContentBlockModule.contentblock', 'Добавить блок контента'), 'url' => array('/contentblock/defaultAdmin/create')),
        array('label' => Yii::t('ContentBlockModule.contentblock', 'Блок контента') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ContentBlockModule.contentblock', 'Редактирование блока контента'), 'url' => array(
            '/contentblock/defaultAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ContentBlockModule.contentblock', 'Просмотреть блок контента'), 'url' => array(
            '/contentblock/defaultAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ContentBlockModule.contentblock', 'Удалить блок контента'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/contentblock/defaultAdmin	/delete', 'id' => $model->id),
            'confirm' => Yii::t('ContentBlockModule.contentblock', 'Вы уверены, что хотите удалить блок контента?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Просмотр блока контента'); ?><br />
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
    <?php echo Yii::t('ContentBlockModule.contentblock', 'Код для использования этого блока в шаблоне:'); ?>
    <br /><br />
    <?php echo $example; ?>
</div>