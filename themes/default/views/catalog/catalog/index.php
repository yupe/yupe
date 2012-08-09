<?php
$this->pageTitle = 'Товары';
$this->breadcrumbs = array(Yii::t('catalog', 'Товары'));
?>

<h1>Товары</h1>

<?php $this->widget('zii.widgets.CListView', array(
      'dataProvider' => $dataProvider,
      'itemView' => '_view',
)); ?>
