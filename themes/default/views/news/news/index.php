<?php
$this->pageTitle = 'Новости';
$this->breadcrumbs = array(Yii::t('news', 'Новости'));
?>

<h1>Новости</h1>

<?php $this->widget('zii.widgets.CListView', array(
      'dataProvider' => $dataProvider,
      'itemView' => '_view',
)); ?>
