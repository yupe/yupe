<?php
/** @var $themes YTheme[] */
?>
    <div class="page-header">
        <h1><?php echo Yii::t('AppearanceModule.messages', 'Темы оформления');?>
            <small><?php echo Yii::t('AppearanceModule.messages', 'выбор');?></small>
        </h1>
    </div>

    <script>
        jQuery(function ($) {
            $('body').on('click', '.toggleTheme', function (event) {
                event.preventDefault();
                $.ajax({
                    'url': '<?php echo CHtml::normalizeUrl(array('/appearance/theme/toggle'));?>',
                    'success': function () {
                        $.fn.yiiListView.update("themesListView");
                    },
                    'data': {
                        'themeID': $(this).data('theme-id'),
                        '<?php echo Yii::app()->getRequest()->csrfTokenName;?>': '<?php echo Yii::app()->getRequest()->csrfToken;?>'
                    },
                    'type': 'POST',
                    'cache': false
                });
            });
        });
    </script>
<?php
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'id'           => 'themesListView',
        'template'     => '{items}',
        'dataProvider' => $themes,
        'itemView'     => '_themeAtList'
    )
);
?>