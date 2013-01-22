<?php
class EThumbnail extends CComponent
{
    private $_thumbnail;
    
    public function __construct($thumbnail) {
        $this->_thumbnail=$thumbnail;
    }
    /**
     * Re-sizes this image to the given dimensions.
     * @param integer $width the maximum width.
     * @param integer $height the maximum height.
     * @return EThumbnail
     */
    public function resize($width=0,$height=0)
    {
            $this->_thumbnail=$this->_thumbnail->resize($width,$height);
            return $this;
    }

    /**
     * Resizes the image to the given dimensions as close as possible,
     * then crops it from center.
     * @param integer $width the width to crop the image to.
     * @param integer $height the height to crop the image to.
     * @return EThumbnail
     */
    public function adaptiveResize($width,$height)
    {
            $this->_thumbnail=$this->_thumbnail->adaptiveResize($width,$height);
            return $this;
    }

    /**
     * Resizes this image by the given percent uniformly.
     * @param integer $percent the percent to resize by.
     * @return EThumbnail
     */
    public function resizePercent($percent)
    {
            $this->_thumbnail=$this->_thumbnail->resizePercent($percent);
            return $this;
    }

    /**
     * Crops this image from the given coordinates with the specified width and height.
     * This is also known as Vanilla-cropping.
     * @param integer $x the starting x-coordinate.
     * @param integer $y the starting y-coordinate.
     * @param integer $width the width to crop with.
     * @param integer $height the height to crop with.
     * @return EThumbnail
     */
    public function crop($x,$y,$width,$height)
    {
            $this->_thumbnail=$this->_thumbnail->crop($x,$y,$width,$height);
            return $this;
    }

    /**
     * Crops this image from the center with the specified width and height.
     * @param integer $width the width to crop with.
     * @param integer $height the height to crop with, if null the height will be the same as the width.
     * @return EThumbnail
     */
    public function cropFromCenter($width,$height=null)
    {
            $this->_thumbnail=$this->_thumbnail->cropFromCenter($width,$height);
            return $this;
    }

    /**
     * Rotates this image by 90 degrees in the specified direction.
     * @param string $direction the direction to rotate the image in.
     * @return EThumbnail
     */
    public function rotateImage($direction='CW')
    {
            $this->_thumbnail=$this->_thumbnail->rotateImage($direction);
            return $this;
    }

    /**
     * Rotates this image by the specified amount of degrees.
     * The image is always rotated clock-wise.
     * @param integer $degrees the amount of degrees.
     * @return EThumbnail
     */
    public function rotateImageNDegrees($degrees)
    {
            $this->_thumbnail=$this->_thumbnail->rotateImageNDegrees($degrees);
            return $this;
    }

    /**
     * Saves this image.
     * @param string $path the path where to save the image.
     * @param string $extension the file extension.
     * @return EThumbnail
     */
    public function save($path,$extension=null)
    {
            $this->_thumbnail=$this->_thumbnail->save($path,$extension);
            return $this;
    }

    /**
     * Renders this image.
     * @return EThumbnail
     */
    public function show()
    {
            $this->_thumbnail=$this->_thumbnail->show();
            return $this;
    }
}
?>
