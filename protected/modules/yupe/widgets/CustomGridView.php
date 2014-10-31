<?php
/**
 *   Widget CustomGridView
 *
 * @category Widgets
 * @package  yupe.modules.yupe.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 * @todo     можно реализовать мультиекшен на основе вызова
 *             метода из CustomGridView и обращаться непосредственно
 *             к модели.
 **/

namespace yupe\widgets;

use CHtml;
use Yii;
use yupe\models\Settings;
use CClientScript;

Yii::import('bootstrap.widgets.TbExtendedGridView');

class CustomGridView extends \TbExtendedGridView
{
    /**
     *  model name variable
     * @access private
     * @see  CustomGridView()
     * @uses init, returnBootstrapStatusHtml, getUpDownButtons, _updatePageSize
     * @var string
     */
    private $_modelName;

    /**
     * @todo if this an unused variable - need to delete it
     */
    public $inActiveStatus = 0;

    /**
     * @todo if this an unused variable - need to delete it
     */
    public $activeStatus = 1;

    /**
     *  Field for sorting:
     * @uses getUpDownButtons
     * @var string
     */
    public $sortField = 'sort';

    /**
     * @todo if this an unused variable - need to delete it
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
     * @uses renderHeadline
     * @var string
     **/
    const HP_LEFT = 'left';
    const HP_RIGHT = 'right';

    /**
     *  Value of headlinePosition:
     * @uses renderHeadline
     * @var string
     **/
    public $headlinePosition = self::HP_RIGHT;

    public $template = "{pager}{summary}{multiaction}\n{items}\n{extendedSummary}\n{pager}<div class='pull-right' style='margin: 26px 0;'>{headline}</div>";

    public $ajaxUrl;

    public $selectableRows = 2;

    public $pagerCssClass = 'pager-container';

    public $actionsButtons = true;

    public function renderBulkActions()
    {
        \Booster::getBooster()->registerAssetJs('jquery.saveselection.gridview.js');
        $this->componentsAfterAjaxUpdate[] = "$.fn.yiiGridView.afterUpdateGrid('" . $this->id . "');";
        echo '<tr><td colspan="' . count($this->columns) . '">';
        if(!empty($this->bulk)) {
            $this->bulk->renderButtons();
        }
        if (!empty($this->actionsButtons)) {
            if(is_array($this->actionsButtons)) {
                foreach($this->actionsButtons as $button) {
                    echo $button;
                }
            }else{
                echo CHtml::link(
                    Yii::t('YupeModule.yupe', 'Add'),
                    ['/' . $this->getController()->getModule()->getId() . '/' . lcfirst($this->_modelName) . 'Backend/create'],
                    ['class' => 'btn btn-success pull-right btn-sm']
                );
            }
        }
        echo '</td></tr>';
    }

    public function renderTableFooter()
    {
        $this->bulk = null;
        parent::renderTableFooter();
    }

    public function renderTableHeader()
    {
        if (!$this->hideHeader) {
            echo "<thead>\n";

            $this->renderBulkActions();

            if ($this->filterPosition === self::FILTER_POS_HEADER) {
                $this->renderFilter();
            }

            echo "<tr>\n";
            foreach ($this->columns as $column) {
                $column->renderHeaderCell();
            }
            echo "</tr>\n";

            if ($this->filterPosition === self::FILTER_POS_BODY) {
                $this->renderFilter();
            }

            echo "</thead>\n";
        } elseif ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }

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
            ? (array)Yii::app()->getController()->getAction()->getId()
            : $this->ajaxUrl;

        $this->bulkActions = empty($this->bulkActions) ? array(
            'class'                => 'booster.widgets.TbBulkActions',
            'align'                => 'right',
            'actionButtons'        => array(
                array(
                    'id'         => 'delete-' . strtolower($this->_modelName),
                    'buttonType' => 'button',
                    'context'    => 'danger',
                    'size'       => 'small',
                    'label'      => Yii::t('YupeModule.yupe', 'Delete'),
                    'click'      => 'js:function (values) { if(!confirm("' . Yii::t(
                            'YupeModule.yupe',
                            'Do you really want to delete selected elements?'
                        ) . '")) return false; multiaction("delete", values); }',
                ),
            ),
            'checkBoxColumnConfig' => array(
                'name' => 'id'
            )
        ) : $this->bulkActions;

        $this->type = empty($this->type) ? 'striped condensed' : $this->type;

        $this->bulkActionAlign = 'left';

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
        $modSettings = Yii::app()->getUser()->getState(\YWebUser::STATE_MOD_SETTINGS, null);
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
            } // Check for value at session or use default value
            elseif (isset($modSettings[strtolower($this->_modelName)]['pageSize'])) {
                $pagination->pageSize = $modSettings[strtolower($this->_modelName)]['pageSize'];
            }
        }
    }

    /**
     *   Function for rendering Up/Down buttons:
     *
     * @param class $data - incomming model instance
     *
     * @return UpDownLinks
     */
    public function getUpDownButtons($data)
    {
        $downUrlImage = '<i class="fa fa-fw fa-arrow-circle-down"></i>';

        $upUrlImage = '<i class="fa fa-fw fa-arrow-circle-up"></i>';

        $urlUp = Yii::app()->getController()->createUrl(
            "sort",
            array(
                'model'     => $this->_modelName,
                'id'        => $data->id,
                'sortField' => $this->sortField,
                'direction' => 'up',
            )
        );

        $urlDown = Yii::app()->getController()->createUrl(
            "sort",
            array(
                'model'     => $this->_modelName,
                'id'        => $data->id,
                'sortField' => $this->sortField,
                'direction' => 'down',
            )
        );

        $options = array('onclick' => 'ajaxSetSort(this, "' . $this->id . '"); return false;',);

        return CHtml::link($upUrlImage, $urlUp, $options) . ' ' . CHtml::link($downUrlImage, $urlDown, $options);
    }

    /**
     * Обновление размера страницы
     *
     * @return void
     */
    protected function _updatePageSize()
    {

        // имя текущей модели
        $modelName = strtolower($this->_modelName);

        // Делаем так, ибо при попытке править Yii::app()->session['modSettings'] - получаем ошибку
        $sessionSettings = Yii::app()->getUser()->getState(\YWebUser::STATE_MOD_SETTINGS, null);
        $currentPageSize = $this->dataProvider->getPagination()->pageSize;

        // Если переменная не найдена нужно проверить наличие данных в БД
        if (!isset($sessionSettings[$modelName]['pageSize'])) {

            $sessionSettings[$modelName] = array();
            $setting = Settings::model()->findAllByAttributes(
                array(
                    'user_id'    => Yii::app()->getUser()->getId(),
                    'module_id'  => $modelName,
                    'param_name' => 'pageSize',
                    'type'       => Settings::TYPE_USER,
                )
            );

            // Если не найдена запись, создаем
            if (null === $setting) {
                $setting = new Settings();
                $setting->module_id = $modelName;
                $setting->param_name = 'pageSize';
                $setting->param_value = $currentPageSize;
                $setting->type = Settings::TYPE_USER;
                $setting->save();
            }
        } // Если информация найдена в сессии и значение отличается
        elseif ($currentPageSize !== $sessionSettings[$modelName]['pageSize']) {

            // Обновим запись в базе
            $setting = Settings::model()->findByAttributes(
                array(
                    'user_id'    => Yii::app()->getUser()->getId(),
                    'module_id'  => $modelName,
                    'param_name' => 'pageSize',
                    'type'       => Settings::TYPE_USER
                )
            );

            // Если не найдена запись, создаем
            if (null === $setting) {
                $setting = new Settings();
                $setting->module_id = $modelName;
                $setting->param_name = 'pageSize';
                $setting->param_value = $currentPageSize;
                $setting->type = Settings::TYPE_USER;
                $setting->save();
            } else {
                $setting->param_value = $currentPageSize;
                $setting->update(['param_value']);
            }
        }

        $sessionSettings[$modelName]['pageSize'] = $currentPageSize;

        // Перезаписываем сессию
        Yii::app()->getUser()->setState(\YWebUser::STATE_MOD_SETTINGS, $sessionSettings);
    }

    /**
     * Headline rendering method
     *
     * @return void
     */
    public function renderHeadline()
    {
        if (!$this->_pageSizesEnabled || $this->dataProvider->itemCount < 5) {
            return;
        }

        $buttons = [];

        $currentPageSize = $this->dataProvider->getPagination()->pageSize;

        /* Перебор переключателей: */
        foreach ($this->pageSizes as $pageSize) {
            $buttons[] = array(
                'label'       => $pageSize,
                'active'      => $pageSize == $currentPageSize,
                'htmlOptions' => array(
                    'class' => 'pageSize',
                    'rel'   => $pageSize,
                ),
                'url'         => '#',
            );
        }

        echo Yii::t('YupeModule.yupe', 'Display on');

        /* Отрисовываем переключатели PageSize'a: */
        $this->widget(
            'bootstrap.widgets.TbButtonGroup',
            array(
                'size'    => 'small',
                'buttons' => $buttons
            )
        );

        /* Скрипт передачи PageSize: */
        $csrfTokenName = Yii::app()->getRequest()->csrfTokenName;
        $csrfToken = Yii::app()->getRequest()->getCsrfToken();
        $csrf = Yii::app()->getRequest()->enableCsrfValidation === false
        || strtolower($this->ajaxType) != 'post'
            ? ""
            : ", '$csrfTokenName':'{$csrfToken}'";
        Yii::app()->getClientScript()->registerScript(
            __CLASS__ . '#' . $this->id . 'ExHeadline',
            <<<JS
            (function () {
    $('body').on('click', '#{$this->getId()} .pageSize', function (event) {
        event.preventDefault();
        $('#{$this->getId()}').yiiGridView('update',{
            // Если в гриде нет записей
            // будет вылетать с ошибкой - Uncaught TypeError: Cannot call method 'match' of undefined
            // В данном случае необходимо указывать URL.
            url: window.location.href,
            data: {
                '{$this->pageSizeVarName}': $(this).attr('rel')$csrf
            }
        });
    });
})();
JS
            ,
            CClientScript::POS_READY
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
     * @return nothing
     */
    public function renderMultiaction()
    {
        Yii::app()->getClientScript()->registerScript(
            __CLASS__ . '#' . $this->id . 'ExMultiaction',
            'var multiaction = function (action, values) {
                var queryString = "";
                var url = "' . Yii::app()->getController()->createUrl('multiaction') . '";
                $.map(values, function (itemInput) {
                    queryString += ((queryString.length > 0) ? "&" : "") + "items[]=" + itemInput;
                });
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: "' . Yii::app()->getRequest()->csrfTokenName . '=' . Yii::app()->getRequest()->getCsrfToken(
            ) . '&model=' . $this->_modelName . '&do=" + action + "&" + queryString,
                    success: function (data) {
                        if (data.result) {
                            $.fn.yiiGridView.update("' . $this->id . '");
                        } else {
                            alert(data.data);
                        }
                    },
                    error: function (data) {alert("' . Yii::t('YupeModule.yupe', 'Error!') . '")}
                });
            }',
            CClientScript::POS_BEGIN
        );
    }
}
