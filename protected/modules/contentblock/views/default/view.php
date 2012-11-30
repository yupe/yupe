<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contentblock')->getCategory() => array(),
        Yii::t('contentblock', 'Блоки контента') => array('/contentblock/default/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('catalog', 'Блоки контента - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('contentblock', 'Управление блоками контента'), 'url' => array('/contentblock/default/index')),
        array('icon' => 'plus-sign','label' => Yii::t('contentblock', 'Добавить блок контента'), 'url' => array('/contentblock/default/create')),
        array('label' => Yii::t('contentblock', 'Блок контента') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('contentblock', 'Редактирование блока контента'), 'url' => array(
            '/contentblock/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('contentblock', 'Просмотреть блок контента'), 'url' => array(
            '/contentblock/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('contentblock', 'Удалить блок контента'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/contentblock/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('contentblock', 'Вы уверены, что хотите удалить блок контента?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('contentblock', 'Просмотр блока контента'); ?><br />
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
    <?php echo Yii::t('contentblock', 'Код для использования этого блока в шаблоне:'); ?>
    <br /><br />
    <?php echo $example; ?>
</div>