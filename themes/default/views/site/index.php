<?php $this->pageTitle = Yii::app()->getModule('yupe')->siteDescription; ?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
    'template'     => "{items}\n{pager}",
)); ?>

<?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi'); ?>