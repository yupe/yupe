<?php

class CommentModule extends YWebModule
{
    public $defaultCommentStatus = Comment::STATUS_APPROVED;

    public $autoApprove = false;

    public function getParamsLabels()
    {
        return array(
            'defaultCommentStatus' => Yii::t('comment','Статус комментариев по умолчанию'),
            'autoApprove'          => Yii::t('comment','Автоматическое подтверждение комментариев')
        );
    }

    public function getEditableParams()
    {
        return array('defaultCommentStatus','autoApprove');
    }

    public function getCategory()
    {
        return Yii::t('comment', 'Контент');
    }

    public function getName()
    {
        $count = Comment::model()->new()->cache(5)->count();
        return $count ? Yii::t('comment', 'Комментарии') . " ($count)"
            : Yii::t('comment', 'Комментарии');
    }

    public function getDescription()
    {
        return Yii::t('comment', 'Модуль для простых комментариев');
    }

    public function getVersion()
    {
        return Yii::t('comment', '0.2');
    }

    public function getAuthor()
    {
        return Yii::t('comment', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('comment', 'aopeykin@yandex.ru');
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
    }
}
