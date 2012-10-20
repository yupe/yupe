<?php
Yii::import('bootstrap.widgets.TbGridView');

class YCustomGridView extends TbGridView
{
    public $modelName;

    public $inActiveStatus = 0;
    public $activeStatus   = 1;

    public $sortField      = 'sort';
    public $showStatusText = false;

    public function init()
    {
        parent::init();

        $this->modelName = $this->dataProvider->modelClass;
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
        $funcStatus = 'get' . $method;
        $funcStatusList = 'get' . $method . 'List';

        $text = method_exists($data, $funcStatus) ? $data->$funcStatus() : '';
        $iconStatus = isset($icons[$data->$statusField]) ? $icons[$data->$statusField] : 'question-sign';

        $icon = '<i class="icon icon-' . $iconStatus . '" title="' . $text . '"></i>';

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
                    if(is_numeric($keyNext))
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
}