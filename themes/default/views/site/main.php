<?php $this->pageTitle = $this->yupe->siteName; ?>

<?php $this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
    'template'     => "{items}\n{pager}",
)); ?>