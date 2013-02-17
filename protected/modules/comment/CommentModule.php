<?php
class CommentModule extends YWebModule
{
    public $defaultCommentStatus;
    public $autoApprove          = false;
    public $notify               = false;
    public $email;

    public function getDependencies()
    {
        return array(
            'user',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'defaultCommentStatus' => Yii::t('CommentModule.comment', 'Статус комментариев по умолчанию'),
            'autoApprove'          => Yii::t('CommentModule.comment', 'Автоматическое подтверждение комментариев'),
            'notify'               => Yii::t('CommentModule.comment', 'Уведомить о новом комментарии?'),
            'email'                => Yii::t('CommentModule.comment', 'Email для уведомлений?'),
            'adminMenuOrder'       => Yii::t('CommentModule.comment', 'Порядок следования в меню'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'defaultCommentStatus' => Comment::model()->getStatusList(),
            'autoApprove'          => $this->getChoice(),
            'notify'               => $this->getChoice(),
            'email',
            'adminMenuOrder',
        );
    }

    public function getCategory()
    {
        return Yii::t('CommentModule.comment', 'Контент');
    }

    public function getName()
    {
        return Yii::t('CommentModule.comment', 'Комментарии');
    }

    public function checkSelf()
    {
        $count = Comment::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->new()->count();

        $messages = array();

        if ($count)
            $messages[YWebModule::CHECK_NOTICE][] = array(
                'type'    => YWebModule::CHECK_NOTICE,
                'message' => Yii::t('CommentModule.comment', 'У Вас {{count}} новых комментариев. {{link}}', array(
                    '{{count}}' => $count,
                    '{{link}}'  => CHtml::link(Yii::t('CommentModule.comment', 'Модерация комментариев'), array(
                        '/comment/default/admin/order/status.asc/Comment_sort/status/',
                    )),
                )),
            );

        return isset($messages[YWebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getDescription()
    {
        return Yii::t('CommentModule.comment', 'Модуль для простых комментариев');
    }

    public function getVersion()
    {
        return Yii::t('CommentModule.comment', '0.4');
    }

    public function getAuthor()
    {
        return Yii::t('CommentModule.comment', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CommentModule.comment', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('CommentModule.comment', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "comment";
    }
    
    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Список комментариев'), 'url'=>array('/comment/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('CommentModule.comment', 'Добавить комментарий'), 'url' => array('/comment/default/create')),
        );
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'comment.components.*',
                'comment.models.*',
            )
        );

        if (!$this->email)
            $this->email = Yii::app()->getModule('yupe')->email;

        $this->defaultCommentStatus = Comment::STATUS_APPROVED;
    }
}