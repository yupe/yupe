<?php
/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsBase.php';

/**
 * Base class for all plugins which require a Facebook application ID.
 */
abstract class EFaceplugsAppLink extends EFaceplugsBase
{
    public function  run()
    {
        parent::run();

        if (!isset ($this->app_id) && YII_DEBUG) {
            throw new CException('Plugin of type "' . get_class($this) . '" requires the Facebook application ID to be set.');
        }
    }
}