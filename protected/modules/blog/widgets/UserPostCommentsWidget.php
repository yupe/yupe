<?php

class UserPostCommentsWidget extends yupe\widgets\YWidget
{
    public $view = 'userpostcomments';

    public $userId;

    public function init()
    {
        if (!$this->userId) {
            throw new CException(Yii::t('BlogModule.blog', 'userId is not defined'));
        }

        parent::init();
    }

    public function run()
    {
        Yii::import('application.modules.comment.CommentModule');

        Comment::model()->metaData->addRelation('post', [CActiveRecord::BELONGS_TO, 'Post', 'model_id']);

        $criteria = new CDbCriteria();
        $criteria->alias = 'comment';
        $criteria->with = ['post', 'post.blog'];
        $criteria->compare('model', 'Post');
        $criteria->compare('post.status', Post::STATUS_PUBLISHED);
        $criteria->compare('blog.status', Blog::STATUS_ACTIVE);
        $criteria->compare('blog.type', Blog::TYPE_PUBLIC);
        $criteria->compare('user_id', $this->userId);
        $criteria->addCondition('level <> 1');

        $dataProvider = new CActiveDataProvider(
            'Comment', [
                'criteria' => $criteria,
                'sort' => [
                    'defaultOrder' => 'comment.id DESC',
                ],
            ]
        );

        $this->render($this->view, ['dataProvider' => $dataProvider]);
    }
}
