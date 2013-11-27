<div class="services">
	<ul class="auth-services clear">
		<?php
		foreach ($services as $name => $service) {
			echo '<li class="auth-service ' . $service->id . '">';
			$html = '<span class="auth-icon ' . $service->id . '"><i></i></span>';
			$html .= '<span class="auth-title">' . $service->title . '</span>';
			$html = CHtml::link($html, array($action, 'service' => $name), array(
				'class' => 'auth-link ' . $service->id,
			));
			echo $html;
			echo '</li>';
		}
		?>
	</ul>
</div>
