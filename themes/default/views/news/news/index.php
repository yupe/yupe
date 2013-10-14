<?php
$this->pageTitle = Yii::t('NewsModule.news', 'News');
$this->breadcrumbs = array(Yii::t('NewsModule.news', 'News'));
?>

<h1>Новости</h1>

<?php $this->widget('zii.widgets.CListView', array(
      'dataProvider' => $dataProvider,
      'itemView' => '_view',
)); ?>
