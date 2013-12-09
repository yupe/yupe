<?php
$this->breadcrumbs = array(   
    Yii::t('UserModule.user', 'Users') => array('/user/userBackend/index'),
    Yii::t('UserModule.user', 'Tokens') => array('/user/tokensBackend/index'),
    Yii::t('UserModule.user', 'View token') . ' #' . $model->id,
);

$this->pageTitle = Yii::t('UserModule.user', 'View token') . ' #' . $model->id;

$this->menu = array(
    array('label' => Yii::t('UserModule.user', 'Users'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Manage users'), 'url' => array('/user/userBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Create user'), 'url' => array('/user/userBackend/create')),
    )),
    array('label' => Yii::t('UserModule.user', 'Tokens'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Token list'), 'url' => array('/user/tokensBackend/index')),
    )),
    array('label' => Yii::t('UserModule.user', 'Token') . ' #' . $model->id, 'items' => array(
    	array('icon' => 'eye-open', 'label' => Yii::t('UserModule.user', 'View'), 'url' => array('/user/tokensBackend/view', 'id' => $model->id)),
        array('icon' => 'pencil', 'label' => Yii::t('UserModule.user', 'Update'), 'url' => array('/user/tokensBackend/update', 'id' => $model->id)),
        array(
        	'icon' => 'trash', 'label' => Yii::t('UserModule.user', 'Delete'), 'url' => array(
        		'/user/tokensBackend/delete', 'id' => $model->id
        	), 'linkOptions' => array(
        		'ajax'       => $this->getDeleteLink($model),
        	)
        ),
    )),
); ?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'view token')  . ' #' . $model->id; ?></small>
    </h1>
</div>

<?php $this->widget(
	'bootstrap.widgets.TbDetailView', array(
		'data'       => $model,
		'attributes' => array(
			'id',
			array(
				'name'  => 'user_id',
				'value' => $model->getFullName(),
			),
			'token',
			array(
				'name'  => 'type',
				'value' => $model->getType(),
			),
			array(
				'name'  => 'status',
				'value' => $model->getStatus(),
			),
			array(
				'name' => 'created',
				'value' => $model->beautifyDate($model->created),
			),
			array(
				'name' => 'updated',
				'value' => $model->beautifyDate($model->updated),
			),
			'ip'
		),
	)
); ?>