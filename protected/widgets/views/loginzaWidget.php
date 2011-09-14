<?php if (Yii::app()->user->isGuest) {
	$url = $token_url.Yii::app()->createAbsoluteUrl($return_url
			, array('providers_set'=>implode(',',$providers_set)));
	echo CHtml::link($link_anchor, $url, array('class'=>$css_class));
} else {
	$anchor = 'Выйти ('.Yii::app()->user->getName().')';
	echo CHtml::link($anchor, array($logout_url));
}
?>