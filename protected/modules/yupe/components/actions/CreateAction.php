<?php
/**
 * Обобщённый экшн для создания сущностей.
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

class CreateAction extends CAction
{
    /**
     * @var string Model class for action.
     */
    public $modelClass;

    /**
     * @var string model scenario
     */
    public $modelScenario = 'insert';

    /**
     * @var string|array|null|callable url for return after success create. If null, action will redirect on current page.
     */
    public $returnUrl;

    /**
     * @var string|callable the name of the view to be rendered.
     */
    public $view = 'create';

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

    public function run()
    {
        $modelClass = $this->modelClass;

        $model = new $this->modelClass($this->modelScenario);

        $controller = $this->getController();

        if ($this->layout !== null) {
            $layout = $controller->layout;
            $controller->layout = is_callable($this->layout) ? call_user_func($this->layout) : $this->layout;
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

    protected function getSuccessMessage()
    {
        return $this->successMessage ?: Yii::t('YupeModule.yupe', 'Record was created!');
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
