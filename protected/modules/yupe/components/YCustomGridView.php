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
*/
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
     *  default page size:
     *  @uses init
     *  @var integer
     **/
    const DEFAULT_PAGE_SIZE = 10;

    /**
     *  The count of items displayed per page: 
     *  @uses init, renderHeadline
     *  @var integer
     **/
    private $_pageSize;

    /**
     *  Default value for the count of items to display (can be changed in widgetCall):
     *  @uses renderHeadline
     *  @var integer
     **/
    public $pageSizes = array(5, 10, 15, 20, 50, 100);

    /**
    *   Widget initialize function:
    *
    *   @return None
    */
    public function init()
    {
        $this->_modelName = $this->dataProvider->modelClass;
        /* Если существует настройки pageSize для этой модели - устанавливаем, иначе - DEFAULT_PAGE_SIZE: */
        $this->_pageSize = isset(Yii::app()->session['modSettings'][strtolower($this->_modelName)]['pageSize'])?Yii::app()->session['modSettings'][strtolower($this->_modelName)]['pageSize']:self::DEFAULT_PAGE_SIZE;
        /* Если существует запрос на установку количества эллементов на страницу: */
        if (Yii::app()->request->getParam('pageSize') !== null)
            $this->_pageSize = Yii::app()->request->getParam('pageSize');
        /* Устанавливаем PageSize: */
        $this->dataProvider->pagination->pageSize = $this->_pageSize;
        /* Инициализируем родителя: */
        parent::init();
        /* Добавляем headline с возможностью переключения PageSize: */
        $this->template = "{headline}\n" . $this->template;
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
                $val; // unused variable
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
            Yii::t('yupe', 'Опустить ниже'),
            array('title' => Yii::t('yupe', 'Опустить ниже'))
        );

        $upUrlImage = CHtml::image(
            Yii::app()->assetManager->publish(Yii::getPathOfAlias('zii.widgets.assets.gridview') . '/up.gif'),
            Yii::t('yupe', 'Поднять выше'),
            array('title' => Yii::t('yupe', 'Поднять выше'))
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
     *  Function for update PageSize:
     *
     *  @return nothing
     */
    private function _updatePageSize()
    {
        /* ID текущей модели: */
        $module_id = strtolower($this->_modelName);
        /* Индикатор изменения PageSize: */
        $changedPageSize = false;
        /* Если для данного модуля не установлен pageSize - устанавливаем его: */
        if (!isset(Yii::app()->session['modSettings'][$module_id]['pageSize'])) {
            $newSettings = new Settings;
            $newSettings->module_id = $module_id;
            $newSettings->creation_date = date('Y-m-d H:i:s');
            $newSettings->change_date = date('Y-m-d H:i:s');
            $newSettings->user_id = Yii::app()->user->id;
            $newSettings->param_name = 'pageSize';
            $newSettings->param_value = Yii::app()->request->getParam('pageSize');
            $newSettings->type = Settings::TYPE_USER;
            $newSettings->save();
            $changedPageSize = true;
            
        }
        /* Получаем настройки модулей: */
        $settings = Settings::model()->fetchUserModuleSettings(Yii::app()->user->id);
        /* Объявляем массив настроек для сессии: */
        $sessionSettings = array();
        /* Проходим по массиву настроек наполняя сессию: */
        if (!empty($settings) && is_array($settings)) {
            /* Парсим все параметры и обновляем данные в сессии: */
            foreach ($settings as $sets) {
                /* Если есть атрибуты - продолжаем: */
                if (isset($sets->attributes)) {
                    if ( (!$changedPageSize) && ($sets->module_id == $module_id) && ($sets->param_name == 'pageSize')) {
                        $sets->param_value = Yii::app()->request->getParam('pageSize');
                        $sets->change_date = date('Y-m-d H:i:s');
                        $sets->update();
                        $changedPageSize = true;
                    }
                    /* Наполняем нашу сессию: */
                    $sessionSettings[$sets->module_id][$sets->param_name] = $sets->param_value;
                }
            }
        }
        Yii::app()->session['modSettings'] = $sessionSettings;
    }

    /**
     * Function for rendering headline
     *
     *  @return nothing
     */
    public function renderHeadline()
    {
        $cscript = Yii::app()->getClientScript();
        $buttons = array();
        /* Если передан запрос на установку PageSize - обновляем данные: */
        if (Yii::app()->request->getParam('pageSize') !== null) {
            $this->_updatePageSize();
        }
        /* Перебор переключателей: */
        foreach ($this->pageSizes as $pageSize)
            $buttons[] = array(
                'label'       => $pageSize,
                'active'      => $pageSize == $this->_pageSize,
                'htmlOptions' => array(
                    'class' => 'pageSize',
                    'rel'   => $pageSize,
                ),
                'url'         => '#',
            );
        /* Текстовка: */
        echo Yii::t('yupe', 'Количество отображаемых эллементов:') . '<br />';
        /* Отрисовываем переключатели PageSize'a: */
        $this->widget(
            'bootstrap.widgets.TbButtonGroup', array(
                'type' => 'action',
                'toggle' => 'radio',
                'buttons' => $buttons,
            )
        );
        /* Скрипт передачи PageSize: */
        $cscript->registerScript(
            __CLASS__ . '#' . $this->id . 'Ex',
            'jQuery(document).ready(function($) {
                $(document).on("click", ".pageSize", function(){
                    $.fn.yiiGridView.update("' . $this->id . '", {
                        data: "pageSize=" + $(this).attr("rel")
                    });
                });
            });', CClientScript::POS_BEGIN
        );
    }
}