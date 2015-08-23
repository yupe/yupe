<?php

class PublisherController extends \yupe\components\controllers\FrontController
{
    public function actions()
    {
        return [
            'imageUpload' => [
                'class'      => 'yupe\components\actions\YAjaxImageUploadAction',
                'maxSize'    => $this->module->maxSize,
                'mimeTypes'  => $this->module->mimeTypes,
                'types'      => $this->module->allowedExtensions,
                'uploadPath' => $this->module->getUploadPath()
            ],
            'imageChoose' => [
                'class' => 'yupe\components\actions\YAjaxImageChooseAction'
            ],
        ];
    }

    public function filters()
    {
        return [
            ['yupe\filters\YFrontAccessControl'],
        ];
    }

    public function actionWrite()
    {
        $post = new Post();
        $post->blog_id = Yii::app()->getRequest()->getParam('blog-id');
        if (($postId = (int)Yii::app()->getRequest()->getQuery('id'))) {

            $post = Post::model()->findUserPost($postId, Yii::app()->getUser()->getId());

            if (null === $post) {

                throw new CHttpException(404);
            }

        }

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['Post'])) {

            $data = Yii::app()->getRequest()->getPost('Post');

            $data['user_id'] = Yii::app()->getUser()->getId();

            $data['status'] = Yii::app()->getRequest()->getPost('draft', Post::STATUS_PUBLISHED);

            $data['tags'] = Yii::app()->getRequest()->getPost('tags');

            if ($post->createPublicPost($data)) {

                $message = Yii::t('BlogModule.blog', 'Post sent for moderation!');

                $redirect = ['/blog/publisher/my'];

                if ($post->isDraft()) {
                    $message = Yii::t('BlogModule.blog', 'Post saved!');
                }

                if ($post->isPublished()) {

                    $message = Yii::t('BlogModule.blog', 'Post published!');

                    $redirect = ['/blog/post/view', 'slug' => $post->slug];
                }

                Yii::app()->getUser()->setFlash(\yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, $message);

                $this->redirect($redirect);
            }
        }

        $this->render(
            'write',
            ['post' => $post, 'blogs' => (new Blog())->getListForUser(Yii::app()->getUser()->getId())]
        );
    }

    public function actionMy()
    {
        $this->render('my', ['posts' => (new Post())->getForUser(Yii::app()->getUser()->getId())]);
    }

    public function actionDelete()
    {
        if ((new Post())->deleteUserPost(Yii::app()->getRequest()->getQuery('id'), Yii::app()->getUser()->getId())) {

            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->failure();
    }
}
