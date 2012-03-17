Kohana Image Library to Yii v0.2
License: New BSD License
Developed by: miles
Last updated: Oct 18, 2010
Added by: Archaron <tsm@glavset.ru>
--------------------------------
http://www.yiiframework.com/extension/image
Provides methods for the dynamic manipulation of images. Various image formats such as JPEG, PNG, and GIF can be resized, cropped, rotated and sharpened.
All image manipulations are applied to a temporary image. Only the save() method is permanent, the temporary image being written to a specified image file.
Image manipulation methods can be chained efficiently. Recommended order: resize, crop, sharpen, quality and rotate or flip


Usage 

The following code is the component registration in the config file:

'import'=>array(
    ...
    'application.helpers.*',
    ...
),
 
 
'components'=>array(
'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),...
)
See the following code example:

$image = Yii::app()->image->load('images/test.jpg');
$image->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
$image->save(); // or $image->save('images/small.jpg');
or

Yii::import('application.extensions.image.Image');
$image = new Image('images/test.jpg');
$image->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
$image->render();