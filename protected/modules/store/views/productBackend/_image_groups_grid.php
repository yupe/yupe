<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'group-grid',
        'type' => 'condensed striped',
        'ajaxUrl' => Yii::app()->createUrl('/store/groupBackend/index'),
        'afterAjaxUpdate' => 'js:updateGroupDropdown',
        'dataProvider' => $imageGroup->search(),
        'hideBulkActions' => true,
        'template' => '{items} {pager}',
        'pagerCssClass' => 'group-pager',
        'enableHistory' => false,
        'columns' => [
            [
                'class' => 'CCheckBoxColumn',
                'visible' => false,
            ],
            'id',
            'name',
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{delete}',
                'deleteButtonUrl' => function($data){
                    return Yii::app()->createUrl('/store/groupBackend/delete', ['id' => $data->id]);
                },
            ]
        ],
    ]
);
