<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('news')->getCategory() => array(),
        Yii::t('NewsModule.news', 'Новости') => array('/news/default/index'),
        $model->title => array('/news/default/view', 'id' => $model->id),
        Yii::t('NewsModule.news', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'Новости - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'Управление новостями'), 'url' => array('/news/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Добавить новость'), 'url' => array('/news/default/create')),
        array('label' => Yii::t('NewsModule.news', 'Новость') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('NewsModule.news', 'Редактирование новости'), 'url' => array(
            '/news/default/update/',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('NewsModule.news', 'Просмотреть новость'), 'url' => array(
            '/news/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('NewsModule.news', 'Удалить новость'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/news/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('NewsModule.news', 'Вы уверены, что хотите удалить новость?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Редактирование новости'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'languages' => $languages, 'langModels' => $langModels)); ?>
