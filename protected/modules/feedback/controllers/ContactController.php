<?php

/**
 * ContactController контроллер публичной части для формы контактов и раздела faq
 *
 * @category YupeController
 * @package  yupe.modules.feedback.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     https://yupe.ru
 *
 **/

use yupe\widgets\YFlashMessages;

/**
 * Class ContactController
 */
class ContactController extends \yupe\components\controllers\FrontController
{

    /**
     * @var FeedbackService
     */
    protected $feedback;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->feedback = Yii::app()->getComponent('feedback');
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yupe\components\actions\YCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1,
            ],
        ];
    }

    /**
     * @param null $type
     */
    public function actionIndex($type = null)
    {
        $form = new FeedBackForm();

        // если пользователь авторизован - подставить его данные
        if (Yii::app()->getUser()->isAuthenticated()) {
            $form->email = Yii::app()->getUser()->getProFileField('email');
            $form->name = Yii::app()->getUser()->getProFileField('nick_name');
        }

        // проверить не передан ли тип и присвоить его аттрибуту модели
        $form->type = empty($type) ? FeedBack::TYPE_DEFAULT : (int)$type;

        $module = Yii::app()->getModule('feedback');

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['FeedBackForm'])) {

            $form->setAttributes(
                Yii::app()->getRequest()->getPost('FeedBackForm')
            );

            if ($form->validate()) {

                if ($this->feedback->send($form, $module)) {

                    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                        Yii::app()->ajax->success(Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!'));
                    }

                    Yii::app()->getUser()->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!')
                    );

                    $this->redirect(
                        $module->successPage ? [$module->successPage] : ['/feedback/contact/index/']
                    );
                } else {

                    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                        Yii::app()->ajax->failure(
                            Yii::t('FeedbackModule.feedback', 'It is not possible to send message!')
                        );
                    }

                    Yii::app()->getUser()->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        Yii::t('FeedbackModule.feedback', 'It is not possible to send message!')
                    );

                }

            } else {

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->ajax->rawText(CActiveForm::validate($form));
                }
            }
        }

        $this->render('index', ['model' => $form, 'module' => $module]);
    }


    /**
     *
     */
    public function actionFaq()
    {
        $dataProvider = new CActiveDataProvider(
            'FeedBack', [
                'criteria' => [
                    'condition' => 'is_faq = :is_faq AND (status = :sent OR status = :finished)',
                    'params' => [
                        ':is_faq' => FeedBack::IS_FAQ,
                        ':sent' => FeedBack::STATUS_ANSWER_SENDED,
                        ':finished' => FeedBack::STATUS_FINISHED,
                    ],
                    'order' => 'id DESC',
                ],
            ]
        );

        $this->render('faq', ['dataProvider' => $dataProvider]);
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionFaqView($id)
    {
        $id = (int)$id;

        if (empty($id)) {
            throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Page was not found!'));
        }

        $model = FeedBack::model()->answered()->faq()->findByPk($id);

        if (null === $model) {
            throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Page was not found!'));
        }

        $this->render('faqView', ['model' => $model]);
    }
}
