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

use Yii, CAction, Image;

class YAjaxImageChooseAction extends CAction
{
    public function run()
    {
        if(Yii::app()->hasModule("image") && Yii::app()->getModule('image')->getIsActive())
        {
            $upPath = '/'. Yii::app()->getModule('yupe')->uploadPath .
                      '/' . Yii::app()->getModule('image')->uploadPath .
                      '/';

            $imgs = Image::model()->findAllByAttributes(
                array('category_id' => null, 'parent_id' => null)
            );

            if(!empty($imgs))
            {
                foreach($imgs as $img)
                    $forJson[] = array(
                        'thumb' => $upPath.$img->file,
                        'image' => $upPath.$img->file,
                        'title' => $upPath.$img->name
                    );

                echo json_encode($forJson);
            }

            Yii::app()->end();
        }
    }
} 