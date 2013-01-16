<?php
	$geo = Yii::app()->getModule('geo');
	$this->breadcrumbs = array(
		$geo->getCategory() => array('/yupe/backend/index', 'category' => $geo->getCategoryType() ),
        Yii::t('GeoModule.geo', 'ГЕО-Локация'),
    );

    Yii::t('GeoModule.geo', 'ГЕО-Локация');

    $this->menu = array();
?>
<div class="page-header">
    <h1>В разработке</h1>
</div>