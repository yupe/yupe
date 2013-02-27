<?php
class GalleryWidget extends YWidget
{
    // сколько изображений выводить на одной странице
    const IMAGE_PER_PAGE = 5;
    // id галереи
    public $id;

    public function run()
    {
        $dataProvider = new CActiveDataProvider('ImageToGallery', array(
            'criteria'   => array(
                'condition' => 'gallery_id = :gallery_id',
                'params'    => array(':gallery_id' => $this->id),
                'limit'     => self::IMAGE_PER_PAGE,
                'order'     => 't.creation_date DESC',
                'with'      => 'image',
            ),
            'pagination' => array('pageSize' => self::IMAGE_PER_PAGE),
        ));

        $this->render('gallerywidget', array(
            'dataProvider' => $dataProvider,
        ));
    }
}