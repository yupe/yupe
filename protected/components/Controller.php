<?php
/**
 * Controller is the customized base front controller class.
 * All front controllers in all modules extends from this base class.
 */
namespace application\components;

use yupe\components\controllers\Controller as BaseController;

/**
 * Class Controller
 * @package application\components
 *
 * @property string|array $title
 * @property string $metaDescription
 * @property string $metaKeywords
 * @property array $metaProperties
 * @property string $canonical
 */
class Controller extends BaseController
{
    public $layout;

    /**
     * Contains data for "CBreadcrumbs" widget (navigation element on a site,
     * a look "Main >> Category 1 >> Subcategory 1")
     */
    public $breadcrumbs = [];

    /**
     * Contains data for "CMenu" widget (provides view for menu on the site)
     */
    public $menu = [];

}
