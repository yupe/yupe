<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yupe\components\image;

use Imagine\Image\Palette\RGB;
use Yii;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;

/**
 * Ported Yii 2 imagine wrapper for Yii 1
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 */
class Imagine
{
    /**
     * GD2 driver definition for Imagine implementation using the GD library.
     */
    const DRIVER_GD2 = 'gd2';
    /**
     * imagick driver definition.
     */
    const DRIVER_IMAGICK = 'imagick';
    /**
     * gmagick driver definition.
     */
    const DRIVER_GMAGICK = 'gmagick';
    /**
     * @var array|string the driver to use. This can be either a single driver name or an array of driver names.
     * If the latter, the first available driver will be used.
     */
    public static $driver = [self::DRIVER_GMAGICK, self::DRIVER_IMAGICK, self::DRIVER_GD2];

    /**
     * @var ImagineInterface instance.
     */
    private static $_imagine;

    /**
     * Returns the `Imagine` object that supports various image manipulations.
     * @return ImagineInterface the `Imagine` object
     */
    public static function getImagine()
    {
        if (self::$_imagine === null) {
            self::$_imagine = static::createImagine();
        }

        return self::$_imagine;
    }

    /**
     * @param ImagineInterface $imagine the `Imagine` object.
     */
    public static function setImagine($imagine)
    {
        self::$_imagine = $imagine;
    }

    /**
     * Creates an `Imagine` object based on the specified [[driver]].
     * @return ImagineInterface the new `Imagine` object
     * @throws \CException      if [[driver]] is unknown or the system doesn't support any [[driver]].
     */
    protected static function createImagine()
    {
        foreach ((array)static::$driver as $driver) {
            switch ($driver) {
                case self::DRIVER_GMAGICK:
                    if (class_exists('Gmagick', false)) {
                        return new \Imagine\Gmagick\Imagine();
                    }
                    break;
                case self::DRIVER_IMAGICK:
                    if (class_exists('Imagick', false)) {
                        return new \Imagine\Imagick\Imagine();
                    }
                    break;
                case self::DRIVER_GD2:
                    if (function_exists('gd_info')) {
                        return new \Imagine\Gd\Imagine();
                    }
                    break;
                default:
                    throw new \CException("Unknown driver: $driver");
            }
        }
        throw new \CException(
            "Your system does not support any of these drivers: " . implode(
                ',',
                (array)static::$driver
            )
        );
    }

    /**
     * Crops an image.
     *
     * For example,
     *
     * ~~~
     * $obj->crop('path\to\image.jpg', 200, 200, [5, 5]);
     *
     * $point = new \Imagine\Image\Point(5, 5);
     * $obj->crop('path\to\image.jpg', 200, 200, $point);
     * ~~~
     *
     * @param  string $filename the image file path or path alias.
     * @param  integer $width the crop width
     * @param  integer $height the crop height
     * @param  array $start the starting point. This must be an array with two elements representing `x` and `y` coordinates.
     * @return ImageInterface
     * @throws \CException    if the `$start` parameter is invalid
     */
    public static function crop($filename, $width, $height, array $start = [0, 0])
    {
        if (!isset($start[0], $start[1])) {
            throw new \CException('$start must be an array of two elements.');
        }

        return static::getImagine()
            ->open($filename)
            ->copy()
            ->crop(new Point($start[0], $start[1]), new Box($width, $height));
    }

    /**
     * Creates a thumbnail image. The function differs from [[\Imagine\Image\ImageInterface::thumbnail()]] function that
     * it keeps the aspect ratio of the image.
     * @param  string $filename the image file path or path alias.
     * @param  integer $width the width in pixels to create the thumbnail
     * @param  integer $height the height in pixels to create the thumbnail
     * @param  string $mode
     * @return ImageInterface
     */
    public static function thumbnail($filename, $width, $height, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        $box = new Box($width, $height);
        $img = static::getImagine()->open($filename);

        if (($img->getSize()->getWidth() <= $box->getWidth() && $img->getSize()->getHeight() <= $box->getHeight()) ||
            (!$box->getWidth() && !$box->getHeight())
        ) {
            return $img->copy();
        }

        $img = $img->thumbnail($box, $mode);

        // create empty image to preserve aspect ratio of thumbnail
        $thumb = static::getImagine()->create($box, (new RGB())->color('FFF', 100));

        // calculate points
        $size = $img->getSize();

        $startX = 0;
        $startY = 0;
        if ($size->getWidth() < $width) {
            $startX = ceil($width - $size->getWidth()) / 2;
        }
        if ($size->getHeight() < $height) {
            $startY = ceil($height - $size->getHeight()) / 2;
        }

        $thumb->paste($img, new Point($startX, $startY));

        return $thumb;
    }

    /**
     * Adds a watermark to an existing image.
     * @param  string $filename the image file path or path alias.
     * @param  string $watermarkFilename the file path or path alias of the watermark image.
     * @param  array $start the starting point. This must be an array with two elements representing `x` and `y` coordinates.
     * @return ImageInterface
     * @throws \CException    if `$start` is invalid
     */
    public static function watermark($filename, $watermarkFilename, array $start = [0, 0])
    {
        if (!isset($start[0], $start[1])) {
            throw new \CException('$start must be an array of two elements.');
        }

        $img = static::getImagine()->open($filename);
        $watermark = static::getImagine()->open($watermarkFilename);
        $img->paste($watermark, new Point($start[0], $start[1]));

        return $img;
    }

    /**
     * Draws a text string on an existing image.
     * @param string $filename the image file path or path alias.
     * @param string $text the text to write to the image
     * @param string $fontFile the file path or path alias
     * @param array $start the starting position of the text. This must be an array with two elements representing `x` and `y` coordinates.
     * @param array $fontOptions the font options. The following options may be specified:
     *
     * - color: The font color. Defaults to "fff".
     * - size: The font size. Defaults to 12.
     * - angle: The angle to use to write the text. Defaults to 0.
     *
     * @return ImageInterface
     * @throws \CException    if `$fontOptions` is invalid
     */
    public static function text($filename, $text, $fontFile, array $start = [0, 0], array $fontOptions = [])
    {
        if (!isset($start[0], $start[1])) {
            throw new \CException('$start must be an array of two elements.');
        }

        if (!isset($fontOptions['size'], $fontOptions['color'], $fontOptions['angle'])) {
            throw new \CException('$fontOptions must contain size, color and angle keys.');
        }

        $fontSize = $fontOptions['size'];
        $fontColor = $fontOptions['color'];
        $fontAngle = $fontOptions['angle'];

        $img = static::getImagine()->open($filename);
        $font = static::getImagine()->font($fontFile, $fontSize, (new RGB())->color($fontColor));

        $img->draw()->text($text, $font, new Point($start[0], $start[1]), $fontAngle);

        return $img;
    }

    /**
     * Adds a frame around of the image. Please note that the image size will increase by `$margin` x 2.
     * @param  string $filename the full path to the image file
     * @param  integer $margin the frame size to add around the image
     * @param  string $color the frame color
     * @param  integer $alpha the alpha value of the frame.
     * @return ImageInterface
     */
    public static function frame($filename, $margin = 20, $color = '666', $alpha = 100)
    {
        $img = static::getImagine()->open($filename);

        $size = $img->getSize();

        $pasteTo = new Point($margin, $margin);

        $box = new Box($size->getWidth() + ceil($margin * 2), $size->getHeight() + ceil($margin * 2));

        $image = static::getImagine()->create($box, (new RGB())->color($color, $alpha));

        $image->paste($img, $pasteTo);

        return $image;
    }

    public static function resize($filename, $width, $height)
    {
        $image = static::getImagine()->open($filename);

        $realWidth = $image->getSize()->getWidth();
        $realHeight = $image->getSize()->getHeight();

        if ($realWidth > $width || $realHeight > $height) {
            $ratio = $realWidth / $realHeight;

            if ($ratio > 1) {
                $height = $width / $ratio;
            } else {
                $width = $height * $ratio;
            }

            $image->resize(new \Imagine\Image\Box($width, $height));
        }

        return $image;
    }
}
