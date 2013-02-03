<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $layout;

    /**
     * Contains data for "CBreadcrumbs" widget (navigation element on a site, 
     * a look "Main >> Category 1 >> Subcategory 1")
     */
    public $breadcrumbs = array();

    /**
     * Contains data for "CMenu" widget (provides view for menu on the site)
     */
    public $menu = array();

}