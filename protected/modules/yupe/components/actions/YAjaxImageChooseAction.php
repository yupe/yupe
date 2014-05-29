<?php
/**
 * YAjaxImageUploadAction.php file.
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components.actions
 * @author   Anton Kucherov <idexter.ru@gmail.com>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.1
 * @link     http://yupe.ru
 */

namespace yupe\components\actions;

use Yii;
use CAction;
use Image;

class YAjaxImageChooseAction extends CAction
{
    public function run()
    {
        if (Yii::app()->hasModule("image") && Yii::app()->getModule('image')->getIsActive())
        {
            $images = Image::model()->findAll();

            if (!empty($images))
            {
                foreach ($images as $img)
                    $forJson[] = array(
                        'thumb' => $img->getImageUrl(300, 300, false),
                        'image' => $img->getImageUrl(),
                        'title' => $img->name,
                        'folder' => $img->gallery->name ? : 'Без галереи',
            );

                echo json_encode($forJson);
            }

            Yii::app()->end();
        }
    }
} 