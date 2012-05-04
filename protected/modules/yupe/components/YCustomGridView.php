<?php
Yii::import('zii.widgets.grid.CGridView');

class YCustomGridView extends CGridView
{
    public $modelName;

    public $activeStatus = 1;

    public $inActiveStatus = 0;

    public $statusField = 'status';

    public $showStatusText = false;

    public  function init()
    {
        parent::init();

        $this->modelName = $this->dataProvider->modelClass;
    }

    public function returnStatusHtml($data, $active = 1, $onclick = 1, $ignore = 0)
    {
        $statusField = $this->statusField;

        $status = $data->$statusField == $active ? $this->inActiveStatus : $this->activeStatus;

        $url = Yii::app()->controller->createUrl("activate", array(
            'model' => $this->modelName,
            'id' => $data->id,
            'status' => $status,
            'statusField' => $this->statusField
        ));

        $img = CHtml::image(
            Yii::app()->request->baseUrl . '/images/' . ($data->$statusField == $active ? '' : 'in') . 'active.png',
            Yii::t('yupe', $data->$statusField ? Yii::t('yupe','Деактивировать') : Yii::t('yupe','Активировать')),
            array('title' => Yii::t('yupe', $data->$statusField ? Yii::t('yupe','Деактивировать') : Yii::t('yupe','Активировать')))
        );
        $options = array();
        if ($onclick) {
            $options = array(
                'onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;',
            );
        }
        $text = ($this->showStatusText && method_exists($data,'getStatus')) ? $data->getStatus() : '';

        return '<div align="center">' . CHtml::link($img, $url, $options) . $text .'</div>';
    }
}