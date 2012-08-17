<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->mim;
$label = mb_strtoupper(mb_substr($label,0,1)).mb_substr($label,1);

echo "\$this->breadcrumbs=array(   
    Yii::app()->getModule('{$this->mid}')->getCategory() => array('admin'), 
	Yii::t('{$this->mid}','$label')=>array('index'),
	\$model->{$nameColumn},
);\n";
?>
$this->pageTitle = Yii::t('<?php echo $this->mid;?>','<?php echo $label ?> - просмотр');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('<?php echo $this->mid;?>','Управление <?php echo $this->mtvor;?>'),'url'=>array('/<?php echo $this->controller; ?>/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('<?php echo $this->mid;?>','Добавление <?php echo $this->rod;?>'),'url'=>array('/<?php echo $this->controller; ?>/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('<?php echo $this->mid;?>','Редактирование <?php echo  $this->rod;?>'),'url'=>array('/<?php echo $this->controller; ?>/update','<?php echo  $this->tableSchema->primaryKey; ?>'=>$model-><?php echo  $this->tableSchema->primaryKey; ?>)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('<?php echo $this->mid;?>','Просмотреть '). '<?php echo  $this->vin; ?>','url'=>array('/<?php echo $this->controller; ?>/view','<?php echo  $this->tableSchema->primaryKey; ?>'=>$model-><?php echo  $this->tableSchema->primaryKey; ?>)),
    array('icon'=>'remove', 'label' =>  Yii::t('<?php echo $this->mid;?>','Удалить <?php echo $this->vin;?>'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo  $this->tableSchema->primaryKey; ?>),'confirm'=> <?php echo "Yii::t('{$this->mid}','Вы уверены, что хотите удалить?')"?>)),
);
?>
<div class="page-header">
    <h1><?php echo "<?php echo Yii::t('{$this->mid}','Просмотр');?>" ;?> <?php echo $this->rod."<br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  \$model->{$nameColumn}; ?>"; ?>&raquo;</small></h1>
</div>

<?php echo  "<?php"; ?> $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ),
)); ?>
