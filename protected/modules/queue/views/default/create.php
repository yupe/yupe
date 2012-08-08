<?php
$this->breadcrumbs = array(
    'задания'=> array('index'),
    'Создание',
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => 'Управление заданиями', 'url' => array('/queue/default/index')),
    array('icon' => 'file', 'label' => 'Добавление задание', 'url' => array('/queue/default/create')),
);
?>
<div class="page-header">
    <h1>задания
        <small>добавление</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model'=> $model)); ?>