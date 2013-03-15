<?php
/**
 * @author Egor Saveiko aka GOsha
 * @version 1.0
 */

class loid extends CApplicationComponent
{
    /**
     * Language name in 'en_EN' format
     * @var string
     */
    private $_language;

    /**
     * init function
     */
    public function init()
    {
        parent::init();
        $dir = dirname(__FILE__);
        $alias = md5($dir);
        Yii::setPathOfAlias($alias,$dir);
        Yii::import($alias.'.LightOpenID');
    }

    /**
     * Main extension loader
     * @param array $config - configuration array
     * @return upload
     */
    public function load($config = array())
    {
	$openid = new LightOpenID();
	if(!empty($config))
	{
	    foreach ($config as $key => $val)
	    {
		$openid->$key = $val;
	    }
	}
	return $openid;
    }
 

}



?>
