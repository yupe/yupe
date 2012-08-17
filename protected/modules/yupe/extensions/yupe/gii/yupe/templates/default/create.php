<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->mim;
$label = mb_strtoupper(mb_substr($label,0,1)).mb_substr($label,1);

echo "<?php\n";
echo "\$this->breadcrumbs=array(    
	Yii::app()->getModule('{$this->mid}')->getCategory() => array('admin'),
	Yii::t('{$this->mid}','$label')=>array('index'),
	Yii::t('{$this->mid}','Добавление'),
);\n";
?>

$this->pageTitle = Yii::t('<?php echo $this->mid ?>','<?php echo $label ?> - добавление');

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('<?php echo $this->mid;?>','Управление <?php echo $this->mtvor;?>'),'url'=>array('/<?php echo $this->controller; ?>/index')),
    array('icon'=> 'file', 'label' => Yii::t('<?php echo $this->mid;?>','Добавить <?php echo $this->vin;?>'),'url'=>array('/<?php echo $this->controller; ?>/create')),
);
?>
<div class="page-header">
    <h1><?php echo "<?php echo Yii::t('{$this->mid}','$label');?>"; ?>
    <small><?php echo "<?php echo Yii::t('{$this->mid}','добавление');?>"?></small>
    </h1>
</div>
<?php echo  "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
