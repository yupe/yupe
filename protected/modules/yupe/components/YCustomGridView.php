<?php
Yii::import('zii.widgets.grid.CGridView');

class YCustomGridView extends CGridView
{
    public $modelName;

    public $inActiveStatus = 0;
    public $activeStatus   = 1;

    public $statusField = 'status';
    public $sortField   = 'sort';

    public $showStatusText = false;

    public  function init()
    {
        parent::init();

        $this->modelName = $this->dataProvider->modelClass;
    }

    public function returnStatusHtml($data, $active = 1, $onclick = 1, $ignore = 0)
    {
        $statusField = $this->statusField;

        $status = ($data->$statusField == $active) ? $this->inActiveStatus : $this->activeStatus;

        $url = Yii::app()->controller->createUrl("activate", array(
            'model'       => $this->modelName,
            'id'          => $data->id,
            'status'      => $status,
            'statusField' => $this->statusField,
        ));

        $img = CHtml::image(
            Yii::app()->request->baseUrl . '/web/images/' . ($data->$statusField == $active ? '' : 'in') . 'active.png',
            Yii::t('yupe', $data->$statusField ? Yii::t('yupe', 'Деактивировать') : Yii::t('yupe', 'Активировать')),
            array('title' => Yii::t('yupe', $data->$statusField ? Yii::t('yupe', 'Деактивировать') : Yii::t('yupe', 'Активировать')))
        );

        $options = array();

        if ($onclick)
            $options = array('onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;');

        $text = ($this->showStatusText && method_exists($data, 'getStatus')) ? $data->getStatus() : '';

        return '<div align="center">' . CHtml::link($img, $url, $options) . $text . '</div>';
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
    public function returnBootstrapStatusHtml($data, $active = 1, $icons = array('eye-close', 'ok-sign', 'time'))
    {
        $statusField = $this->statusField;

        $status = ($data->$statusField == $active) ? $this->inActiveStatus : $this->activeStatus;

        $url = Yii::app()->controller->createUrl("activate", array(
            'model'       => $this->modelName,
            'id'          => $data->id,
            'status'      => $status,
            'statusField' => $this->statusField,
        ));

        $options = array('onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;');

        $iconStatus = isset($icons[ $data->$statusField]) ? $icons[ $data->$statusField] : 'question-sign';
        $text = method_exists($data,'getStatus') ? $data->getStatus() : '';
        $iconTitle = Yii::t('yupe', $data->$statusField ? Yii::t('yupe', 'Деактивировать') : Yii::t('yupe', 'Активировать'));

        $icon = '<i class="icon icon-' . $iconStatus . '" title="' . $text . ', ' . $iconTitle . '"></i>';

        return CHtml::link($icon, $url, $options);
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