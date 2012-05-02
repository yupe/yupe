<?php
class CommentModule extends YWebModule
{
    public $defaultCommentStatus = Comment::STATUS_APPROVED;
    public $autoApprove = false;
    public $notify = true;
    public $email;

    public function getParamsLabels()
    {
        return array(
            'defaultCommentStatus' => Yii::t('comment','Статус комментариев по умолчанию'),
            'autoApprove' => Yii::t('comment','Автоматическое подтверждение комментариев'),
            'notify' => Yii::t('comment','Уведомить о новом комментарии?'),
            'email' => Yii::t('comment','Email для уведомлений?'),
            'adminMenuOrder' => Yii::t('comment','Порядок следования в меню')
        );
    }

    public function getEditableParams()
    {
        return array(
            'defaultCommentStatus' => Comment::model()->getStatusList(),
            'autoApprove' => $this->getChoice(),
            'notify' => $this->getChoice(),
            'email',
            'adminMenuOrder'
        );
    }

    public function getCategory()
    {
        return Yii::t('comment', 'Контент');
    }

    public function getName()
    {
        $count = Comment::model()->new()->cache(5)->count();

        return $count
            ? Yii::t('comment', 'Комментарии')." ($count)"
            : Yii::t('comment', 'Комментарии');
    }

    public function getDescription()
    {
        return Yii::t('comment', 'Модуль для простых комментариев');
    }

    public function getVersion()
    {
        return Yii::t('comment', '0.3');
    }

    public function getAuthor()
    {
        return Yii::t('comment', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('comment', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('comment', 'http://yupe.ru');
    }


    public function init()
    {
        parent::init();

        $this->setImport(array(
            'comment.models.*',
        ));

        if(!$this->email)
            $this->email = Yii::app()->getModule('yupe')->email;
    }
}