<?php
namespace yupe\components;

use Yii;
use CTheme;

class Theme extends CTheme
{
    public $resourceFolder = 'web';

    private $_assetsUrl;

    public function getAssetsUrl()
    {
        if (null === $this->_assetsUrl) {
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                $this->getBasePath() . DIRECTORY_SEPARATOR . $this->resourceFolder
            );
        }

        return $this->_assetsUrl;
    }
}
