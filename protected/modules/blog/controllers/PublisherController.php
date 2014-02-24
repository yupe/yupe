<?php

class PublisherController extends yupe\components\controllers\FrontController
{
    public function filters()
    {
        return array(
            array('yupe\filters\YFrontAccessControl'),
        );
    }

    public function actionWrite()
    {
        $post = new Post();

        if (($postId = (int)Yii::app()->getRequest()->getQuery('id'))) {

            $post = Post::model()->findUserPost($postId, Yii::app()->getUser()->getId());

            if (null === $post) {

                throw new CHttpException(404);
            }

        }

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['Post'])) {

            $module = Yii::app()->getModule('blog');

            $status = isset($_POST['publish']) ? (int)$module->publicPostStatus : Post::STATUS_DRAFT;

            $data = Yii::app()->getRequest()->getPost('Post');

            $data['user_id'] = Yii::app()->user->getId();

            if ($post->createPublicPost($data, Yii::app()->getRequest()->getPost('tags'), $status)) {

                $message = Yii::t('BlogModule.blog', 'Post sent for moderation!');

                $redirect = array('/blog/publisher/my');

                if ($status == Post::STATUS_DRAFT) {
                    $message = Yii::t('BlogModule.blog',  'Post saved!');
                }

                if ($status == Post::STATUS_PUBLISHED) {

                    $message = Yii::t('BlogModule.blog', 'Post published!');

                    $redirect = array('/blog/post/show', 'slug' => $post->slug);
                }

                Yii::app()->getUser()->setFlash(\yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, $message);

                $this->redirect($redirect);
            }
        }

        $this->render('write', array('post' => $post));
    }

    public function actionMy()
    {
        $this->render('my', array('posts' => Post::model()->getForUser(Yii::app()->user->getId())));
    }

    public function actionDelete()
    {
        if (Post::model()->deleteUserPost(Yii::app()->getRequest()->getQuery('id'), Yii::app()->getUser()->getId())) {

            Yii::app()->ajax->success();

        }

        Yii::app()->ajax->failure();
    }
} 