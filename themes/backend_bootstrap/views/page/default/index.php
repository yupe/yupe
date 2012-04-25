<?php $this->pageTitle = Yii::t('page', 'Список страниц'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы'),
);

$this->menu = array(
    array('label' => Yii::t('page', 'Добавить страницу'), 'url' => array('create')),
    array('label' => Yii::t('page', 'Управление страницами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('page', 'Страницы');?></h1>

<?php

$pages = Page::model()-> findAll();
foreach ($pages as $p)
{
    $pages_byparent[$p->parent_Id][$p->id] = $p;
    $pages_byid[$p->id] = $p;
}

$organized_pages = array();

function rec_walk( $pages_byparent, $page=0 )
{
    $pg = null;
    if ( isset($pages_byparent[$page]) )
    {
        foreach ( $pages_byparent[$page] as $p )
        {


            $pp=array( 'id' => $p->id );
            if ( isset($pages_byparent[$p->id]) )
                    $pp['children'] = rec_walk( $pages_byparent, $p->id );

            $btns = CHtml::link("<i class='icon-plus-sign'></i>", array('default/create', 'Page[parent_Id]' => $p->id), array('class' => 'page_add' ) );
            if ( !isset($pp['children']) )
                $btns .= CHtml::link("<i class='icon-trash'></i>", array('default/delete', 'id' => $p->id), array('class' => 'page_delete' ) );

            $btns .= CHtml::link("<i class='icon-edit'></i>", array('default/update', 'id' => $p->id), array('class' => 'page_edit' ) );

            $pp['text'] = "<i class='icon-file'></i>".CHtml::link($p->title,array('default/view', 'id' => $p->id)).$btns;

            $pg[]=$pp;
        }
    }
    return $pg;
}


//$dataProvider-> pagination = false;
//$data = $dataProvider-> fetchData();
$data =array();
$data[0]= array( "text" => "<i class='icon-home'></i>".Yii::app()->name, 'id' => 0, 'children' => rec_walk( $pages_byparent )) ;

//$data =  rec_walk( $pages_byparent ) ;

$this->widget('CTreeView', array( 'data' => $data, 'persist' => true, 'animated' => 'fast'));

?>
