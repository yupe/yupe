<?php
/**
 * Обобщённый экшн для редактирования какой-либо сущности
 *
 * @category Actions
 * @package yupe.components.actions
 * @since 0.9.4
 */

namespace yupe\components\actions;

use CAction;
use yupe\models\YModel;
use CHttpException;
use Yii;
use CEvent;
use yupe\widgets\YFlashMessages;

class UpdateAction extends CAction
{
    /**
     * @var string Model class for action.
     */
    public $modelClass;

    /**
     * @var string Атрибут модели, с помощью которого она будет найдена.
     */
    public $attribute = 'id';

    /**
     * @var string model scenario
     */
    public $modelScenario = 'update';

    /**
     * @var string|array|null|callable url for return after success update. If null, action will redirect on current page.
     */
    public $returnUrl;

    /**
     * @var string|callable the name of the view to be rendered.
     */
    public $view = 'update';

    /**
     * @var string|callable the name of the layout to be applied to the views.
     * This will be assigned to {@link CController::layout} before the view is rendered.
     * Defaults to null, meaning the controller's layout will be used.
     * If false, no layout will be applied.
     */
    public $layout;

    /**
     * @var string message will be displayed if model was save successfully
     */
    public $successMessage;

    /**
     * @var string message will be displayed if model was not found
     */
    public $errorMessage;

    public function run()
    {
        $attributeValue = Yii::app()->request->getParam($this->attribute);

        $model = $this->loadModel($attributeValue);
        $model->setScenario($this->modelScenario);

        $controller = $this->getController();

        if ($this->layout !== null) {
            $layout = $controller->layout;
            $controller->layout = is_callable($this->layout) ? call_user_func($this->layout, $model) : $this->layout;
        }

        $this->onBeforeRender($event = new CEvent($this));
        if (!$event->handled) {
            if (($data = Yii::app()->request->getPost(get_class($model))) !== null) {
                $model->setAttributes($data);

                if ($model->save()) {
                    Yii::app()->user->setFlash(YFlashMessages::SUCCESS_MESSAGE, $this->getSuccessMessage());

                    if (!isset($_POST['submit-type'])) {
                        /* if returnUrl is null set them to current url */
                        $returnUrl = $this->returnUrl ?: Yii::app()->request->requestUri;
                        /* If this is callable, call it. */
                        $returnUrl = is_callable($returnUrl) ? call_user_func($returnUrl, $model) : $returnUrl;

                        $controller->redirect($returnUrl);
                    } else {
                        $controller->redirect([$_POST['submit-type']]);
                    }
                }
            }

            $controller->render(is_callable($this->view) ? call_user_func($this->view, $model) : $this->view, ['model' => $model]);
            $this->onAfterRender(new CEvent($this));
        }

        if ($this->layout !== null) {
            $controller->layout = $layout;
        }
    }

    protected function loadModel($value)
    {
        $model = YModel::model($this->modelClass)->findByAttributes([$this->attribute => $value]);

        if (!$model) {
            throw new CHttpException(404, $this->getErrorMessage());
        }

        return $model;
    }

    protected function getSuccessMessage()
    {
        return $this->successMessage ?: Yii::t('YupeModule.yupe', 'Record was updated!');
    }

    protected function getErrorMessage()
    {
        return $this->errorMessage ?: Yii::t('YupeModule.yupe', 'Record was not found!');
    }

    /**
     * Raised right before the action invokes the render method.
     * Event handlers can set the {@link CEvent::handled} property
     * to be true to stop further view rendering.
     * @param CEvent $event event parameter
     */
    public function onBeforeRender($event)
    {
        $this->raiseEvent('onBeforeRender', $event);
    }

    /**
     * Raised right after the action invokes the render method.
     * @param CEvent $event event parameter
     */
    public function onAfterRender($event)
    {
        $this->raiseEvent('onAfterRender', $event);
    }
}