<?php
Yii::import('bootstrap.widgets.TbExtendedGridView');

class YCustomGridView extends TbExtendedGridView
{
    public $modelName;

    public $inActiveStatus = 0;
    public $activeStatus   = 1;

    public $sortField      = 'sort';
    public $showStatusText = false;

    /* Дефолтное количество отображаемых элементов: */
    const DEFAULT_PAGE_SIZE = 10;
    /* Количество отображаемых элементов: */
    public $_pageSize;
    /* Дефолтные значения, для количества отображаемых элементов: */
    public $pageSizes = array(5, 10, 15, 20, 50, 100);

    public function init()
    {
        $this->modelName = $this->dataProvider->modelClass;
        /* Если существует настройки pageSize для этой модели - устанавливаем, иначе - DEFAULT_PAGE_SIZE: */
        $this->_pageSize = isset(Yii::app()->session['modSettings'][strtolower($this->modelName)]['pageSize'])?Yii::app()->session['modSettings'][strtolower($this->modelName)]['pageSize']:self::DEFAULT_PAGE_SIZE;
        if (Yii::app()->request->getParam('pageSize') !== null)
            $this->_pageSize = Yii::app()->request->getParam('pageSize');
        $this->dataProvider->pagination->pageSize=$this->_pageSize;

        parent::init();

        $this->template = "{headline}\n".$this->template;
    }

    /**
     * Генерирует HTML-код для BootStrap-иконки переключателя активности в зависимости от текущего состояния модели
     *
     * По-умолчанию значения состояний
     * 0 - Черновик ( деактивировано )
     * 1 - Опубликовано ( активировано )
     * 2 - На модерации
     *
     * @param $data экземпляр модели, для которой нужно вывести переключатель
     * @param int $active номер статуса, считаемый активным
     * @param array $icons массив имен иконок по статусам
     * @return string HTML-код для BootStrap-иконки переключателя
     *
     */
    public function returnBootstrapStatusHtml($data, $statusField = 'status', $method = 'Status', $icons = array('lock', 'ok-sign', 'time'))
    {
        $funcStatus     = 'get' . $method;
        $funcStatusList = 'get' . $method . 'List';

        $text       = method_exists($data, $funcStatus) ? $data->$funcStatus() : '';
        $iconStatus = isset($icons[$data->$statusField]) ? $icons[$data->$statusField] : 'question-sign';
        $icon       = '<i class="icon icon-' . $iconStatus . '" title="' . $text . '"></i>';

        if (method_exists($data, $funcStatusList))
        {
            $statusList = $data->$funcStatusList();

            reset($statusList);
            $status = key($statusList);
            while (list($key, $val) = each($statusList))
            {
                if ($key == $data->$statusField)
                {
                    $keyNext = key($statusList);
                    if (is_numeric($keyNext))
                    {
                        $status = $keyNext;
                        break;
                    }
                }
            }

            $url = Yii::app()->controller->createUrl("activate", array(
                'model'       => $this->modelName,
                'id'          => $data->id,
                'status'      => $status,
                'statusField' => $statusField,
            ));
            $options = array('onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;');

            return CHtml::link($icon, $url, $options);
        }
        return $icon;
    }

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

        $urlUp = Yii::app()->controller->createUrl("sort", array(
            'model'     => $this->modelName,
            'id'        => $data->id,
            'sortField' => $this->sortField,
            'direction' => 'up',
        ));

        $urlDown = Yii::app()->controller->createUrl("sort", array(
            'model'     => $this->modelName,
            'id'        => $data->id,
            'sortField' => $this->sortField,
            'direction' => 'down',
        ));

        $options = array('onclick' => 'ajaxSetSort(this, "' . $this->id . '"); return false;',);

        return  CHtml::link($upUrlImage, $urlUp, $options) . ' ' .
                $data->{$this->sortField} . ' ' .
                CHtml::link($downUrlImage, $urlDown, $options);
    }

    public function renderHeadline()
    {
        $cs = Yii::app()->getClientScript();

        $buttons = array();

        if (Yii::app()->request->getParam('pageSize') !== null)
        {
            $module_id = strtolower($this->modelName);

            if (isset($this->modSettings[$module_id]['pageSize']))
            {
                $settings = Settings::model()->fetchUserModuleSettings(Yii::app()->user->id);
                $sessionSettings = array();
                /* Если передан не пустой массив, проходим по нему: */
                if (!empty($settings) && is_array($settings))
                    foreach ($settings as $s)
                        /* Если есть атрибуты - продолжаем: */
                        if (isset($s->attributes))
                        {
                            if (($s->module_id == $module_id) && ($s->param_name == 'pageSize'))
                            {
                                $s->param_value = Yii::app()->request->getParam('pageSize');
                                $s->change_date = date('Y-m-d H:i:s');
                                $s->update();
                            }
                            /* Наполняем нашу сессию: */
                            if (!isset($sessionSettings[$s->module_id]))
                                $sessionSettings[$s->module_id] = array();
                            $sessionSettings[$s->module_id][$s->param_name] = $s->param_value;
                        }
                Yii::app()->session['modSettings'] = $sessionSettings;
            } else {
                $newSettings = new Settings;
                $newSettings->module_id = $module_id;
                $newSettings->creation_date = date('Y-m-d H:i:s');
                $newSettings->change_date = date('Y-m-d H:i:s');
                $newSettings->user_id = Yii::app()->user->id;
                $newSettings->param_name = 'pageSize';
                $newSettings->param_value = Yii::app()->request->getParam('pageSize');
                $newSettings->type = Settings::TYPE_USER;
                $newSettings->save();

                $settings = Settings::model()->fetchUserModuleSettings(Yii::app()->user->id);
                $sessionSettings = array();
                /* Если передан не пустой массив, проходим по нему: */
                if (!empty($settings) && is_array($settings))
                    foreach ($settings as $s)
                        /* Если есть атрибуты - продолжаем: */
                        if (isset($s->attributes))
                        {
                            /* Наполняем нашу сессию: */
                            if (!isset($sessionSettings[$s->module_id]))
                                $sessionSettings[$s->module_id] = array();
                            $sessionSettings[$s->module_id][$s->param_name] = $s->param_value;
                        }
                Yii::app()->session['modSettings'] = $sessionSettings;
            }

        }

        foreach ($this->pageSizes as $pageSize)
            $buttons[] = array(
                'label'       => $pageSize,
                'active'      => $pageSize == $this->_pageSize,
                'htmlOptions' => array(
                    'class'   => 'pageSize',
                    'rel'     => $pageSize,
                ),
                'url'         => '#',
            );

        echo Yii::t('YCustomGridView', 'Количество отображаемых эллементов:').'<br />';

        $this->widget('bootstrap.widgets.TbButtonGroup', array(
            'type' => 'action',
            'toggle' => 'radio',
            'buttons' => $buttons,
        ));

        $cs->registerScript(__CLASS__ . '#' . $this->id . 'Ex','
        jQuery(document).ready(function($) {
            $(document).on("click", ".pageSize", function(){
                $.fn.yiiGridView.update("blog-grid", {
                    data: "pageSize=" + $(this).attr("rel")
                });
            });
        });', CClientScript::POS_BEGIN);
    }
}