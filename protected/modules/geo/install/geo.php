<?php
return array(
    'module'   => array(
        'class' => 'application.modules.geo.GeoModule',
    ),
    'import'    => array(
        'application.modules.geo.*',
        'application.modules.geo.models.*',
    ),
    'component' => array(
        // Если используется модуль geo  - надо как-то интегрировать в сам модуль
        'sxgeo' => array(
            'class'    => 'application.modules.geo.extensions.sxgeo.CSxGeoIP',
            'filename' => dirname(__FILE__)."/../modules/geo/data/SxGeoCity.dat",
        ),
    ),
    'rules'     => array(),
);