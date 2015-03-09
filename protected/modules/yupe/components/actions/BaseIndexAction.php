<?php
/**
 * Обобщённый экшн для листинга сущностей.
 * Простой экшн. Не использует фильтрацию от клиента, не вызывает $model->search(), просто создаёт $dataProvider, по переданному $dataProviderClass, с применением $dataProviderConfig и передаёт его во view.
 * Отлично подходит для листинга на фронтенде, когда контент не нужно фильтровать, а нужно вывести по определённой $criteria.
 *
 * @category Actions
 * @package yupe.components.actions
 * @since 0.9.4
 */

namespace yupe\components\actions;

use CAction;
use Yii;
use CEvent;
use CActiveDataProvider;
use CDbCriteria;
use CMap;
use CException;

class BaseIndexAction extends CAction
{
    /**
     * @var string Model class for action.
     */
    public $modelClass;

    /**
     * @var array|CDbCriteria criteria which applied to $dataProvider
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
        $controller = $this->getController();

        if ($this->layout !== null) {
            $layout = $controller->layout;
            $controller->layout = is_callable($this->layout) ? call_user_func($this->layout) : $this->layout;
        }

        $this->onBeforeRender($event = new CEvent($this));
        if (!$event->handled) {
            $dataProviderClass = $this->dataProviderClass;

            $dataProvider = new $dataProviderClass($this->modelClass, CMap::mergeArray(['criteria' => $this->criteria], $this->dataProviderConfig));

            $controller->render(is_callable($this->view) ? call_user_func($this->view) : $this->view, ['dataProvider' => $dataProvider]);
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