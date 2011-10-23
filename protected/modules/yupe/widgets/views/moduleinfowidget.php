<script type='text/javascript'>
    $(document).ready(function(){    	
    	$('#more-info').click(function(event){
    		event.preventDefault();
    		$('#more-info-div').slideDown();
    		$(this).fadeOut();
    	});
    });
</script>

<p><?php echo $module->getDescription();?>, <?php echo Yii::t('yupe', 'версия')?> <?php echo $module->getVersion();?> <?php echo CHtml::link(Yii::t('yupe','подробнее'),array(),array('id'=>'more-info'));?></p>

<div id='more-info-div' style='display:none;'>
<p><?php echo Yii::t('yupe','Автор');?>: <?php echo $module->getAuthor();?> ( <?php echo $module->getAuthorEmail();?>, <?php echo $module->getUrl();?> )</p>
</div>