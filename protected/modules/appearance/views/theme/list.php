<?php
/** @var $themes YTheme[] */
?>
    <div class="page-header"><h1>Темы оформления <small>выбор</small></h1></div>

    <script>
        jQuery(function ($) {
            $('body').on('click', '.toggleTheme', function (event) {
                event.preventDefault();
                $.ajax({
                    'url': '<?=CHtml::normalizeUrl(array('/appearance/theme/toggle'));?>',
                    'success': function () {
                        $.fn.yiiListView.update("themesListView");
                    },
                    'data': {
                        'themeID': $(this).data('theme-id'),
                        '<?=Yii::app()->getRequest()->csrfTokenName;?>': '<?=Yii::app()->getRequest()->csrfToken;?>'
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
    array('id' => 'themesListView', 'dataProvider' => $themes, 'itemView' => '_themeAtList')
);
?>