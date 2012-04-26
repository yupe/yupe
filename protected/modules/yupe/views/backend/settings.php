<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Настройки'),    
);?>

<h1><?php echo Yii::t('yupe','Настройки');?></h1>

<?php echo Yii::t('yupe','Настройте модули "{app}" под Ваши потребности',array('{app}' => Yii::app()->name));?> -

<?php echo CHtml::link(Yii::t('yupe','перейти к панели управления'),array('/yupe/backend/'));?>