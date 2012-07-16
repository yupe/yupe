<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label= $this->mim;
$label=mb_strtoupper(mb_substr($label,0,1)).mb_substr($label,1);

echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>
$this-> pageTitle ="<?=$label ?> - просмотр";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => 'Управление <?php echo $this->mtvor; ?>','url'=>array('<?=$this->controller; ?>/index')),
    array('icon'=> 'file', 'label' => 'Добавить <?php echo $this->vin; ?>','url'=>array('<?=$this->controller; ?>/create')),
    array('icon'=> 'pencil', 'label' => 'Редактировать <?php echo $this->vin; ?>','url'=>array('<?=$this->controller; ?>/update','<?php echo $this->tableSchema->primaryKey; ?>'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
    array('icon'=> 'eye-open white', 'encodeLabel'=>false, 'label' => 'Просмотр <?php echo $this->rod; ?><br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model-><?=$nameColumn?>,0,32)."</span>",'url'=>array('<?=$this->controller; ?>/view','<?php echo $this->tableSchema->primaryKey; ?>'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
    array('icon'=>'remove', 'label' => 'Удалить <?php echo $this->vin; ?>','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Вы уверены, что хотите удалить?')),
);
?>
<div class="page-header">
    <h1>Просмотр <?php echo $this->rod."<br />
     <small style='margin-left:-10px;'>&laquo;<?php echo \$model->{$nameColumn}; ?>"; ?>&raquo;</small></h1>
</div>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
