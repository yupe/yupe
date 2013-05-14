<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('feedback')->getCategory() => array(),
        Yii::t('FeedbackModule.feedback', 'Сообщения  ') => array('/feedback/default/index'),
        $model->theme,
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Сообщения   - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Управление сообщениями  '), 'url' => array('/feedback/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Добавить сообщение  '), 'url' => array('/feedback/default/create')),
        array('label' => Yii::t('dictionary', 'Значение справочника') . ' «' . mb_substr($model->theme, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('FeedbackModule.feedback', 'Редактирование сообщения  '), 'url' => array(
            '/feedback/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('FeedbackModule.feedback', 'Просмотреть сообщение  '), 'url' => array(
            '/feedback/default/view',
            'id' => $model->id
        )),
        array('icon' => 'envelope', 'label' => Yii::t('FeedbackModule.feedback', 'Ответить на сообщение  '), 'url' => array(
            '/feedback/default/answer',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('FeedbackModule.feedback', 'Удалить сообщение  '), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/feedback/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('FeedbackModule.feedback', 'Вы уверены, что хотите удалить сообщение  ?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Просмотр сообщения  '); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'creation_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->creation_date, "short", "short"),
        ),
        array(
            'name'  => 'change_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->change_date, "short", "short"),
        ),
        'name',
        'email',
        'phone',
        'theme',
         array(
            'name' => 'text',
            'type' => 'raw'
        ),
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name'  => 'category_id',
            'value' => $model->getCategory(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name' => 'answer',
            'type' => 'raw'
        ),
        array(
            'name'  => 'answer_user',
            'value' => $model->getAnsweredUser(),
        ),
        array(
            'name'  => 'answer_date',
            'value' => ($model->answer_date != "0000-00-00 00:00:00")
                ? Yii::app()->dateFormatter->formatDateTime($model->answer_date, 'short')
                : "—",
        ),
        array(
            'name'  => 'is_faq',
            'value' => $model->getIsFaq(),
        ),
        'ip',
    ),
)); ?>
