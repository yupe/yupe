<?php
/**
 * Виджет отрисовки галереи изображений:
 *
 * @category YupeWidget
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class GalleryWidget extends YWidget
{
    // сколько изображений выводить на одной странице
    public $limit = 10;
    
    // ID-галереи
    public $gallery_id;

    // Галерея
    public $gallery;

    /**
     * Запускаем отрисовку виджета
     * 
     * @return void
     */
    public function run()
    {
        Yii::app()->clientScript->registerCssFile(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.modules.gallery.views.assets.css') . '/gallery.css'
            )
        );
        $dataProvider = new CActiveDataProvider(
            'ImageToGallery', array(
                'criteria' => array(
                    'condition' => 't.gallery_id = :gallery_id',
                    'params' => array(':gallery_id' => $this->gallery_id),
                    'limit' => $this->limit,
                    'order' => 't.creation_date DESC',
                    'with' => 'image',
                ),
                'pagination' => array('pageSize' => $this->limit),
            )
        );

        $this->render(
            'gallerywidget',
            array(
                'dataProvider' => $dataProvider,
                'gallery'      => $this->gallery,
            )
        );
    }
}