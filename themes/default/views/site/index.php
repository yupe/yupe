<?php $this->pageTitle = Yii::app()->getModule('yupe')->siteDescription; ?>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                                  'template' => "{items}\n{pager}",
                                             )); ?> 

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>