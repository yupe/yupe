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
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Редактирование',
);\n";
?>
$this-> pageTitle ="<?php echo $label ?> - редактирование";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => 'Управление <?php echo  $this->mtvor; ?>','url'=>array('/<?php echo $this->controller; ?>/index')),
    array('icon'=> 'file', 'label' => 'Добавить <?php echo  $this->vin; ?>','url'=>array('/<?php echo $this->controller; ?>/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => 'Редактирование <?php echo  $this->rod; ?><br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model-><?php echo $nameColumn?>,0,32)."</span>",'url'=>array('<?php echo $this->controller; ?>/update','<?php echo  $this->tableSchema->primaryKey; ?>'=>$model-><?php echo  $this->tableSchema->primaryKey; ?>)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => 'Просмотреть <?php echo  $this->vin; ?>','url'=>array('/<?php echo $this->controller; ?>/view','<?php echo  $this->tableSchema->primaryKey; ?>'=>$model-><?php echo  $this->tableSchema->primaryKey; ?>)),
);
?>
<div class="page-header">
    <h1>Редактирование <?php echo $this->pre; ?><br />
        <small style="margin-left: -10px;">&laquo;<?php echo  " <?php echo  \$model->{$nameColumn}; ?>"; ?>&raquo;</small>
    </h1>
</div>
<?php echo  "<?php echo  \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>