<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label= $this->mim;
$label=mb_strtoupper(mb_substr($label,0,1)).mb_substr($label,1);

echo "<?php\n";
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	Yii::t('yupe','Добавление'),
);\n";
?>

$this->menu=array(
array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление <?php echo $this->mtvor;?>'),'url'=>array('/<?php echo $this->controller; ?>/index')),
    array('icon'=> 'file', 'label' => Yii::t('yupe','Добавление <?php echo $this->rod;?>'),'url'=>array('/<?php echo $this->controller; ?>/create')),
);
?>
<div class="page-header">
    <h1><?php echo "<?php echo Yii::t('yupe','$label');?>"; ?>
    <small><?php echo "<?php echo Yii::t('yupe','добавление');?>"?></small>
    </h1>
</div>
<?php echo  "<?php echo  \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
