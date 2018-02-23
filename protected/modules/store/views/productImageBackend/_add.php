<?php
$this->widget(
    'bootstrap.widgets.TbFileUpload',
    [
        'id' => 'fileUploader',
        'url' => $this->createUrl("/store/productImageBackend/addImages", ['id' => $product->id]),
        'model' => $model,
        'attribute' => 'name',
        'multiple' => true,
        'formView' => 'store.views.productImageBackend._tform',
        'uploadView' => 'store.views.productImageBackend._upload',
        'options' => [
            'maxFileSize' => Yii::app()->getModule('image')->maxSize,
            'acceptFileTypes' => 'js:/(\.|\/)(' . implode(
                    '|',
                    Yii::app()->getModule('image')->allowedExtensions()
                ) . ')$/i',
        ]
    ]
);
