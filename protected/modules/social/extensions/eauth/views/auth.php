<div class="services">
  <ul class="auth-services clear">
  <?php
	foreach ($services as $name => $service) {
		echo '<li class="auth-service '.$service->id.'">';
		$html = '<span class="auth-icon '.$service->id.'"><i></i></span>';
		$html .= '<span class="auth-title">'.$service->title.'</span>';
		$html = CHtml::link($html, array($action, 'service' => $name), array(
			'class' => 'auth-link '.$service->id,
		));
		echo $html;
		echo '</li>';
	}
  ?>
  </ul>

  <?php
    $cs = Yii::app()->clientScript;
	$cs->registerCoreScript('jquery');
	
	$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
	$cs->registerCssFile($url.'/css/auth.css');

	// Open the authorization dilalog in popup window.
	if ($popup) {
		$cs->registerScriptFile($url.'/js/auth.js', CClientScript::POS_HEAD);
		$js = '';
		foreach ($services as $name => $service) {
			$args = $service->jsArguments;
			$args['id'] = $service->id;
			$js .= '$(".auth-service.'.$service->id.' a").eauth('.json_encode($args).');'."\n";
		}
		$cs->registerScript('eauth-services', $js, CClientScript::POS_READY);
	}
  ?>
</div>