<?php
namespace yupe\components;

use Yii;
use CTheme;

/**
 * Class Theme
 * @package yupe\components
 */
class Theme extends CTheme
{
    /**
     * @var string
     */
    public $resourceFolder = 'web';

    /**
     * @var
     */
    private $_assetsUrl;

    /**
     * @return mixed
     */
    public function getAssetsUrl()
    {
        if (null === $this->_assetsUrl) {
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                $this->getBasePath().DIRECTORY_SEPARATOR.$this->resourceFolder
            );
        }

        return $this->_assetsUrl;
    }
}
