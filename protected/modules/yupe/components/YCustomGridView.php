<?php
/**
*   Class of widget YCustomGridView
*
*   @category Widget
*   @package  Yupe
*   @author   Yupe Team <team@yupe.ru>
*   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
*   @link     http://yupe.ru
*/

Yii::import('bootstrap.widgets.TbExtendedGridView');

/**
*   Widget YCustomGridView
*
*   @category Widget
*   @package  Yupe
*   @author   Yupe Team <team@yupe.ru>
*   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
*   @link     http://yupe.ru
*   @todo     можно реализовать мультиекшен на основе вызова
*             метода из YCustomGridView и обращаться непосредственно
*             к модели.
**/
class YCustomGridView extends TbExtendedGridView
{
    /**
     *  model name variable
     *  @access private
     *  @see YCustomGridView()
     *  @uses init, returnBootstrapStatusHtml, getUpDownButtons, _updatePageSize
     *  @var string
     */
    private $_modelName;

    /**
     *  @todo if this an unused variable - need to delete it
     */
    public $inActiveStatus = 0;

    /**
     *  @todo if this an unused variable - need to delete it
     */
    public $activeStatus   = 1;

    /**
     *  Field for sorting:
     *  @uses getUpDownButtons
     *  @var string
     */
    public $sortField      = 'sort';

    /**
     *  @todo if this an unused variable - need to delete it
     */
    public $showStatusText = false;

    /**
     * @var array Page sizes available to set for web-user.
     */
    public $pageSizes = array(5, 10, 15, 20, 50, 100);

    /**
     * @var string A name for query parameter, that stores page size specified by web-user.
     */
    public $pageSizeVarName = 'pageSize';

    /**
     * @var bool Whether rendering of page size selector at headline section is available and enabled.
     */
    protected $_pageSizesEnabled = false;

    /**
     *  constant of headline positions:
     *  @uses renderHeadline
     *  @var string
     **/
    const HP_LEFT  = 'left';
    const HP_RIGHT = 'right';

    /**
     *  Value of headlinePosition:
     *  @uses renderHeadline
     *  @var string
     **/
    public $headlinePosition;

    public $template = "{headline}\n{summary}\n{items}\n{pager}\n{extendedSummary}\n{multiaction}";

    public $ajaxUrl;

    /**
     * Widget initialization
     *
     * @return void
     */
    public function init()
    {
        $this->_modelName = $this->dataProvider->modelClass;
        $this->headlinePosition = empty($this->headlinePosition) ? self::HP_RIGHT : $this->headlinePosition;
        $this->initPageSizes();
        $this->ajaxUrl = empty($this->ajaxUrl)
            ? (array) Yii::app()->controller->action->id
            : $this->ajaxUrl;
        parent::init();
    }

    /**
     * Sets "pageSize" parameter at instance of CPagination which belongs to data provider.
     * The value to set or specified by the web-user or taken from the session, where it is being stored when user specifies it.
     *
     * @return void
     */
    protected function initPageSizes()
    {
        $modSettings = Yii::app()->user->getState('modSettings', null);
        $pagination = $this->dataProvider->getPagination();
        if (
            !$this->enablePagination
            || strpos($this->template, '{headline}') === false
            || $pagination === false
        ) {
            $this->_pageSizesEnabled = false;
        } else {
            $this->_pageSizesEnabled = true;

            // Web-user specifies desired page size.
            if (($pageSizeFromRequest = Yii::app()->getRequest()->getParam($this->pageSizeVarName)) !== null) {
                $pageSizeFromRequest = (int)$pageSizeFromRequest;
                // Check whether given page size is valid or use default value
                if (in_array($pageSizeFromRequest, $this->pageSizes)) {
                    $pagination->pageSize = $pageSizeFromRequest;
                }
                $this->_updatePageSize();
            }
            // Check for value at session or use default value
            elseif(isset($modSettings[strtolower($this->_modelName)]['pageSize'])) {
                $pagination->pageSize = $modSettings[strtolower($this->_modelName)]['pageSize'];
            }
        }
    }

    /**
    *   Generates HTML-code for BootStrap-icons switch activity, depending on the current state of the model
    *   Генерирует HTML-код для BootStrap-иконки переключателя активности в зависимости от текущего состояния модели
    *
    * By default, the state values:
    * 0 - Draft (deactivated)
    * 1 - Posted on (activated)
    * 2 - In Moderation
    *
    * @param class  $data        - a model instance for which generated display the switch
    * @param string $statusField -
    * @param string $method      -
    * @param array  $icons       - an array of names icons statuses
    *
    * @return string HTML-code for BootStrap-switch icon
    *
    */
    public function returnBootstrapStatusHtml($data, $statusField = 'status', $method = 'Status', $icons = array('lock', 'ok-sign', 'time'))
    {
        $funcStatus     = 'get' . $method;
        $funcStatusList = 'get' . $method . 'List';

        $text       = method_exists($data, $funcStatus) ? $data->$funcStatus() : '';
        $iconStatus = isset($icons[$data->$statusField]) ? $icons[$data->$statusField] : 'question-sign';
        $icon       = '<i class="icon icon-' . $iconStatus . '" title="' . $text . '"></i>';

        if (method_exists($data, $funcStatusList)) {
            $statusList = $data->$funcStatusList();

            reset($statusList);
            $status = key($statusList);
            while (list($key, $val) = each($statusList)) {
                $val; // @TODO unused variable
                if ($key == $data->$statusField) {
                    $keyNext = key($statusList);
                    if (is_numeric($keyNext)) {
                        $status = $keyNext;
                        break;
                    }
                }
            }

            $url = Yii::app()->controller->createUrl(
                "activate", array(
                    'model'       => $this->_modelName,
                    'id'          => $data->id,
                    'status'      => $status,
                    'statusField' => $statusField,
                )
            );
            $options = array('onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;');

            return CHtml::link($icon, $url, $options);
        }

        return $icon;
    }

    /**
    *   Function for rendering Up/Down buttons:
    *
    *   @param class $data - incomming model instance
    *
    *   @return UpDownLinks
    */
    public function getUpDownButtons($data)
    {
        $downUrlImage = CHtml::image(
            Yii::app()->assetManager->publish(Yii::getPathOfAlias('zii.widgets.assets.gridview') . '/down.gif'),
            Yii::t('YupeModule.yupe', 'Опустить ниже'),
            array('title' => Yii::t('YupeModule.yupe', 'Опустить ниже'))
        );

        $upUrlImage = CHtml::image(
            Yii::app()->assetManager->publish(Yii::getPathOfAlias('zii.widgets.assets.gridview') . '/up.gif'),
            Yii::t('YupeModule.yupe', 'Поднять выше'),
            array('title' => Yii::t('YupeModule.yupe', 'Поднять выше'))
        );
        $urlUp = Yii::app()->controller->createUrl(
            "sort", array(
                'model'     => $this->_modelName,
                'id'        => $data->id,
                'sortField' => $this->sortField,
                'direction' => 'up',
            )
        );

        $urlDown = Yii::app()->controller->createUrl(
            "sort", array(
                'model'     => $this->_modelName,
                'id'        => $data->id,
                'sortField' => $this->sortField,
                'direction' => 'down',
            )
        );

        $options = array('onclick' => 'ajaxSetSort(this, "' . $this->id . '"); return false;',);

        return  CHtml::link($upUrlImage, $urlUp, $options) . ' ' .
                $data->{$this->sortField} . ' ' .
                CHtml::link($downUrlImage, $urlDown, $options);
    }

    /**
     * Обновление размера страницы
     *
     * @return void
     */
    protected function _updatePageSize()
    {
        // ID текущей модели
        $modelID = strtolower($this->_modelName);
        // Делаем так, ибо при попытке править Yii::app()->session['modSettings'] - получаем ошибку
        $sessionSettings = Yii::app()->user->getState('modSettings', null);
        $currentPageSize = $this->dataProvider->getPagination()->pageSize;

        if (!isset($sessionSettings[$modelID])) {
            $sessionSettings[$modelID] = array();
        }

        // Если для данного модуля не установлен pageSize - устанавливаем его
        if (!isset($sessionSettings[$modelID]['pageSize'])) {
            $newSets = new Settings;
            $newSets->module_id = $modelID;
            $newSets->param_name = 'pageSize';
            $newSets->param_value = $currentPageSize;
            $newSets->type = Settings::TYPE_USER;
            $newSets->save();
        } else {
            $oldSets = Settings::model()->findByAttributes(
                array(
                    'user_id' => Yii::app()->user->getId(),
                    'module_id' => $modelID,
                    'param_name' => 'pageSize',
                    'type' => Settings::TYPE_USER,
                )
            );
            $oldSets->param_value = $currentPageSize;
            $oldSets->update();
        }
        $sessionSettings[$modelID]['pageSize'] = $currentPageSize;
        // Перезаписываем сессию
        Yii::app()->user->setState('modSettings', $sessionSettings);
    }

    /**
     * Headline rendering method
     *
     * @return void
     */
    public function renderHeadline()
    {
        if (!$this->_pageSizesEnabled) {
            return;
        }
        /** @var $cs CClientScript */
        $cs = Yii::app()->getClientScript();
        $buttons = array();
        $currentPageSize = $this->dataProvider->getPagination()->pageSize;

        /* Перебор переключателей: */
        foreach ($this->pageSizes as $pageSize)
            $buttons[] = array(
                'label'       => $pageSize,
                'active'      => $pageSize == $currentPageSize,
                'htmlOptions' => array(
                    'class' => 'pageSize',
                    'rel'   => $pageSize,
                ),
                'url'         => '#',
            );
        /* Установка позиции headline'а: */
        $headlinePosition = '';
        if (in_array($this->headlinePosition, array('left', 'right')))
            $headlinePosition = ' style="text-align: ' . $this->headlinePosition . ';" ';
        echo '<div class="headline" ' . $headlinePosition .' >';
        /* Текстовка: */
        echo Yii::t('YupeModule.yupe', 'Отображать по:') . '<br />';

        /* Отрисовываем переключатели PageSize'a: */
        $this->widget(
            'bootstrap.widgets.TbButtonGroup', array(
                'size'    => 'small',
                'type'    => 'action',
                'toggle'  => 'radio',
                'buttons' => $buttons,
            )
        );
        echo '</div>';
        echo '<br />';
        /* Скрипт передачи PageSize: */
        $cs->registerScript(
            __CLASS__ . '#' . $this->id . 'ExHeadline',
<<<JS
(function(){
    $('body').on('click', '#{$this->getId()} .pageSize', function(event) {
        event.preventDefault();
        $('#{$this->getId()}').yiiGridView('update',{
            // Если в гриде нет записей
            // будет вылетать с ошибкой - Uncaught TypeError: Cannot call method 'match' of undefined 
            // В данном случае необходимо указывать URL.
            url: window.location.href,
            data: {'{$this->pageSizeVarName}': $(this).attr('rel')}
        });
    });
})();
JS
            , CClientScript::POS_READY
        );
    }

    /**
     * Function for rendering multiaction:
     *
     *  JS function variables:
     *      status - type of action:
     *          1  - delete
     *          -------------------
     *
     *  @return nothing
     */
    public function renderMultiaction()
    {
        $cscript = Yii::app()->getClientScript();

        $multiactionUrl = str_replace(Yii::app()->controller->action->id, 'multiaction', Yii::app()->request->requestUri);

        /* Скрипт для мультиекшена: */
        $cscript->registerScript(
            __CLASS__ . '#' . $this->id . 'ExMultiaction',
            'var multiaction = function(action, values) {
                var queryString = "";
                var url = "'.$multiactionUrl.'";
                $.map(values, function(itemInput) {
                    queryString += ((queryString.length > 0) ? "&" : "") + "items[]=" + $(itemInput).val() ;
                });                
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: "'.Yii::app()->request->csrfTokenName.'='.Yii::app()->request->csrfToken.'&model=' . $this->_modelName . '&do=" + action + "&" + queryString,
                    success: function(data) {
                        if (data.result) {                            
                            $.fn.yiiGridView.update("'.$this->id.'");
                        }else{
                            alert(data.data);
                        }
                    },
                    error: function(data){alert("'.Yii::t('YupeModule.yupe','Произошла ошибка!').'")}
                });
            }', CClientScript::POS_BEGIN
        );
    }
}
