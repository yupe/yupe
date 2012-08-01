<?php $currentLanguage = Yii::app()->language; ?>
<?php $cp = Yii::app()->urlManager->getCleanUrl(Yii::app()->request->getPathInfo());?>
<?php $i = 1;?>
<?php $langs = explode(',',Yii::app()->getModule('yupe')->availableLanguages);?>

    <li class="langs">
			<?php foreach($langs as $lang):?>
			    <?php $i++;?>
			    <?php if($currentLanguage == $lang):?>
			    <span>
				   <?php echo strtoupper($lang);?> 
			    </span>
				<?php else:?>
				    <?php echo CHtml::link(strtoupper($lang),Yii::app()->baseUrl.'/index.php/'.$lang.$cp);?>
				<?php endif?>
				<?php if($i == count($langs)):?>|<?php endif;?>
			<?php endforeach;?>			
	</li>


