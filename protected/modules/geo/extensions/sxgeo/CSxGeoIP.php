<?php
Yii::import('application.modules.geo.extensions.sxgeo.SxGeo');

class CSxGeoIP extends CApplicationComponent {

  public $filename = 'data\SxGeo.dat';
  protected static $flags;
  protected static $sxgeoip;

  public function init() {
    self::$sxgeoip = new SxGeo($this->filename, self::$flags?self::$flags:(SXGEO_BATCH | SXGEO_MEMORY));
    // Run parent
    parent::init();
  }

  public function getCountry($ip=null) {
    $ip = $this->_getIP($ip);
    return self::$sxgeoip->getCountry($ip);
  }

  public function getCountryId($ip=null) {
    $ip = $this->_getIP($ip);
    return self::$sxgeoip->getCountryId($ip);
  }

  public function getCity($ip=null) {
    $ip = $this->_getIP($ip);
    return self::$sxgeoip->getCity($ip);
  }

  public function getCityFull($ip=null) {
    $ip = $this->_getIP($ip);
    return self::$sxgeoip->getCityFull($ip);
  }

  public function getAll($ip=null) {
    $ip = $this->_getIP($ip);
    return self::$sxgeoip->get($ip);
  }

  protected function _getIP($ip=null) {
    if ($ip === null) {
      $ip = CHttpRequest::getUserHostAddress();
    }
    return $ip;
  }

}
?>