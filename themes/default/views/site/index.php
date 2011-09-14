<?php $this->pageTitle = 'Юпи! - самый простой способ создать сайт на фреймворке Yii! Мини CMS на Yii!'; ?>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                                  'template' => "{items}\n{pager}",
                                             )); ?>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.yupe.components.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>