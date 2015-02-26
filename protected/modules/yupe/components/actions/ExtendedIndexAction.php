<?php
/**
 * Обобщённый экшн для листинга сущностей.
 * Игнорирует dataProvider, который возвращается методом $model->search() и создаёт свой на основе $dataProviderClass, с применением $dataProviderConfig.
 * Критерия берётся из $model->search(), далее мержится с $criteria, переданной в экшн и передаётся в $dataProvider.
 * Во view будут переданы $dataProvider и $model.
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
use CActiveDataProvider;
use CDbCriteria;
use CMap;
use CException;

class ExtendedIndexAction extends CAction
{
    /**
     * @var string Model class for action.
     */
    public $modelClass;

    /**
     * @var string model scenario
     */
    public $modelScenario = 'search';

    /**
     * @var array|CDbCriteria criteria which applied to $model->search() criteria
     */
    public $criteria = [];

    /**
     * @var string class of dataProvider
     */
    public $dataProviderClass = 'CActiveDataProvider';

    /**
     * @var array dataProvider config
     */
    public $dataProviderConfig = [];

    /**
     * @var string|callable the name of the view to be rendered.
     */
    public $view = 'index';

    /**
     * @var string|callable the name of the layout to be applied to the views.
     * This will be assigned to {@link CController::layout} before the view is rendered.
     * Defaults to null, meaning the controller's layout will be used.
     * If false, no layout will be applied.
     */
    public $layout;

    public function run()
    {
        $modelClass = $this->modelClass;

        /* @var $model YModel */
        $model = new $modelClass($this->modelScenario);

        $model->unsetAttributes();

        if (($data = Yii::app()->request->getParam(get_class($model))) !== null) {
            $model->setAttributes($data);
        }

        $controller = $this->getController();

        if ($this->layout !== null) {
            $layout = $controller->layout;
            $controller->layout = is_callable($this->layout) ? call_user_func($this->layout, $model) : $this->layout;
        }

        $this->onBeforeRender($event = new CEvent($this));
        if (!$event->handled) {
            $dataProvider = $model->search();

            if (empty($dataProvider) || !($dataProvider instanceof CActiveDataProvider)) {
                throw new CException("{$modelClass} should return CActiveDataProvider instance.");
            }

            $criteria = $dataProvider->criteria;

            $criteria->mergeWith($this->criteria);

            $dataProviderClass = $this->dataProviderClass;

            $dataProvider = new $dataProviderClass($model, CMap::mergeArray(['criteria' => $criteria], $this->dataProviderConfig));

            $controller->render(is_callable($this->view) ? call_user_func($this->view, $model) : $this->view, ['dataProvider' => $dataProvider, 'model' => $model]);
            $this->onAfterRender(new CEvent($this));
        }

        if ($this->layout !== null) {
            $controller->layout = $layout;
        }
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