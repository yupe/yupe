<?php
class GalleryWidget extends YWidget
{
    // сколько изображений выводить на одной странице
    public $limit = 10;
    // id галереи
    public $id;

    public function run()
    {
        $dataProvider = new CActiveDataProvider('ImageToGallery', array(
            'criteria' => array(
                'condition' => 'gallery_id = :gallery_id',
                'params' => array(':gallery_id' => $this->id),
                'limit' => $this->limit,
                'order' => 't.creation_date DESC',
                'with' => 'image',
            ),
            'pagination' => array('pageSize' => $this->limit),
        ));

        $this->render(
            'gallerywidget',
            array(
                'dataProvider' => $dataProvider,
            )
        );
    }
}