<?php

/**
 * GalleryWidget виджет отрисовки галереи изображений
 *
 * @category YupeWidget
 * @package  yupe.modules.gallery.widgets
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 */

Yii::import('application.modules.gallery.models.*');

class GalleryWidget extends yupe\widgets\YWidget
{
    // сколько изображений выводить на одной странице
    public $limit = 10;

    // ID-галереи
    public $galleryId;

    // Галерея
    public $gallery;

    public $view = 'gallerywidget';

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
            'ImageToGallery', [
                'criteria'   => [
                    'condition' => 't.gallery_id = :gallery_id',
                    'params'    => [':gallery_id' => $this->galleryId],
                    'limit'     => $this->limit,
                    'order'     => 'image.sort',
                    'with'      => 'image',
                ],
                'pagination' => ['pageSize' => $this->limit],
            ]
        );

        $this->render(
            $this->view,
            [
                'dataProvider' => $dataProvider,
                'gallery'      => $this->gallery,
            ]
        );
    }
}
