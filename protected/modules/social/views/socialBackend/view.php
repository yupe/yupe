<?php
/**
 * Отображение для view:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('social')->getCategory() => array(),
    Yii::t('SocialModule.social', 'Аккаунты')      => array('/social/socialBackend/index'),
    $model->id,
);

$this->pageTitle = Yii::t('social', 'Аккаунты - просмотр');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('SocialModule.social', 'Управление аккаунтами'),
        'url'   => array('/social/socialBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('SocialModule.social', 'Просмотреть аккаунт'),
        'url'   => array(
            '/social/socialBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('SocialModule.social', 'Удалить аккаунт'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/social/socialBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('SocialModule.social', 'Вы уверены, что хотите удалить аккаунт?'),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('SocialModule.social', 'Просмотр') . ' ' . Yii::t('SocialModule.social', 'аккаунта'); ?><br/>
        <small>&laquo;<?php echo $model->provider; ?>&raquo; <?php echo $model->user->getFullName(); ?></small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            array(
                'name'  => 'user_id',
                'value' => $model->user->getFullName()
            ),
            'provider',
            'uid',
        ),
    )
); ?>
