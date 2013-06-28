<?php $this->pageTitle = $this->yupe->siteName; ?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
    'template'     => "{items}\n{pager}",
)); ?>