 <div class="flashes">

	<?php if( Yii::app()->user->hasFlash('RightsSuccess')===true ):?>

	    <div class="flash success">

	        <?php echo Yii::app()->user->getFlash('RightsSuccess'); ?>

	    </div>

	<?php endif; ?>

	<?php if( Yii::app()->user->hasFlash('RightsError')===true ):?>

	    <div class="flash error">

	        <?php echo Yii::app()->user->getFlash('RightsError'); ?>

	    </div>

	<?php endif; ?>

 </div>