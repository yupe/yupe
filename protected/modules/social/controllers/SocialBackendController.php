<?php
namespace application\modules\social\controllers;

/**
 * Класс SocialBackendController:
 *
 * @category Yupe yupe\components\controllers\BackController
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
use yupe\components\controllers\BackController;
use application\modules\social\models\SocialUser;
use CHttpException;
use Yii;
use yupe\widgets\YFlashMessages;

class SocialBackendController extends BackController
{

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['delete'], 'roles' => ['Social.Socialbackend.Delete']],
            ['allow', 'actions' => ['index'], 'roles' => ['Social.Socialbackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Social.Socialbackend.View']],
            ['deny']
        ];
    }

    /**
     * Отображает аккаунт по указанному идентификатору
     *
     * @param integer $id Идинтификатор аккаунт для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Удаляет модель аккаунта из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор аккаунта, который нужно удалить
     *
     * @return void
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('SocialModule.social', 'Record removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t(
                'SocialModule.social',
                'Unknown request. Don\'t repeat it please!'
            ));
        }
    }

    /**
     * Управление аккаунтом.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new SocialUser('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['application_modules_social_models_SocialUser'])) {
            $model->attributes = $_GET['application_modules_social_models_SocialUser'];
        }
        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer идентификатор нужной модели
     *
     * @return void
     */
    public function loadModel($id)
    {
        $model = SocialUser::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('SocialModule.social', 'Page not found!'));
        }

        return $model;
    }
}
