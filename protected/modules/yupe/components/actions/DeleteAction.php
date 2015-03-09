<?php
/**
 * Обобщённый экшн для удаления какой-либо сущности.
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
use CException;

class DeleteAction extends CAction
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
    public $modelScenario = 'delete';

    /**
     * @var string|array|callable url for return after success delete.
     */
    public $returnUrl = ['index'];

    /**
     * @var string message will be displayed if model was successfully deleted.
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

        $this->onBeforeDelete($event = new CEvent($this));
        if (!$event->handled) {
            if ($model->delete()) {
                Yii::app()->user->setFlash(YFlashMessages::SUCCESS_MESSAGE, $this->getSuccessMessage());

                $this->onAfterDelete(new CEvent($this));

                // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
                if (!isset($_GET['ajax'])) {
                    $controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : (is_callable($this->returnUrl) ? call_user_func($this->returnUrl, $model) : $this->returnUrl));
                }
            } else {
                throw new CException(implode(PHP_EOL, $model->getErrors()));
            }
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
        return $this->successMessage ?: Yii::t('YupeModule.yupe', 'Record was deleted!');
    }

    protected function getErrorMessage()
    {
        return $this->errorMessage ?: Yii::t('YupeModule.yupe', 'Record was not found!');
    }

    /**
     * Raised right before the action invokes the model delete method.
     * Event handlers can set the {@link CEvent::handled} property
     * to be true to stop further model delete.
     * @param CEvent $event event parameter
     */
    public function onBeforeDelete($event)
    {
        $this->raiseEvent('onBeforeDelete', $event);
    }

    /**
     * Raised right after the action invokes the delete method.
     * @param CEvent $event event parameter
     */
    public function onAfterDelete($event)
    {
        $this->raiseEvent('onAfterDelete', $event);
    }
}