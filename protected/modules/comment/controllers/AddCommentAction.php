<?php
class AddCommentAction extends CAction
{
    public function run()
    {
        if (Yii::app()->request->isPostRequest && isset($_POST['Comment']))
        {
            $redirect = isset($_POST['redirectTo']) ? $_POST['redirectTo']
                : Yii::app()->user->returnUrl;

            $comment = new Comment();

            $module  = Yii::app()->getModule('comment');

            $comment->setAttributes($_POST['Comment']);

            $comment->status = $module->defaultCommentStatus;            

            if (Yii::app()->user->isAuthenticated())
            {
                $comment->setAttributes(array(
                                             'userId' => Yii::app()->user->getId(),
                                             'name' => Yii::app()->user->getState('nickName'),
                                             'email' => Yii::app()->user->getState('email'),
                                        ));

                if($module->autoApprove)
                {
                    $comment->status = Comment::STATUS_APPROVED;   
                }            
            }

            if ($comment->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    Yii::app()->ajax->success(Yii::t('comment', 'Комментарий добавлен!'));
                }

                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('comment', 'Спасибо, Ваш комментарий добавлен!'));

                $this->controller->redirect($redirect);
            }
            else
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    Yii::app()->ajax->failure(Yii::t('comment', 'Комментарий не добавлен!'));
                }

                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('comment', 'Комментарий не добавлен! Заполните форму корректно!'));

                $this->controller->redirect($redirect);
            }
        }

        throw new CHttpException(404, Yii::t('comment', 'Страница не найдена!'));
    }
}

?>