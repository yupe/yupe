<div id="installer" class="ready">

	<h2><?php echo Rights::t('install', 'Congratulations!'); ?></h2>

	<p class="green-text">
		<?php echo Rights::t('install', 'Rights has been installed succesfully.'); ?>
	</p>

	<p>
		<?php echo Rights::t('install', 'You can start by generating your authorization items') ;?>
		<?php echo CHtml::link(Rights::t('install', 'here'), array('authItem/generate')); ?>.
	</p>

</div>