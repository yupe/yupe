<?php
Yii::app()->user->isAuthenticated()
    ? Yii::app()->clientScript->registerScript(
        "ajaxBlogToken", "var ajaxToken = " . json_encode(
            Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken
        ) . ";", CClientScript::POS_BEGIN
    )
    : '';
$this->pageTitle = Yii::t('blog', 'Блоги');
$this->breadcrumbs = array(Yii::t('blog', 'Блоги'));
?>

<h1>Блоги</h1>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on("click", 'a.action-blog', function (event) {
            event.preventDefault();
            var blogId = parseInt($(this).attr('rel'));
            var url = $(this).attr('type');
            var link = this;
            $.ajax({
                url: baseUrl + '/blog/blog/' + url + '/',
                data: ajaxToken + '&blogId=' +blogId,
                dataType: 'json',
                type: 'post',
                success: function(data) {
                    console.log(data);
                    if (typeof data.data != 'undefined') {
                        var type = data.result ? 'success' : 'error';
                        var message = data.result ? data.data.message : data.data;
                        $(link).parents('.view').before("<div class='flash'><div class='flash-" + type + "'><b>" + message + "</b></div></div>");
                        if (data.result)
                            $(link).parents('.view').replaceWith(data.data.content);
                    } else {
                        $(link).parents('.view').before("<div class='flash'><div class='flash-error'><b><?php echo Yii::t('BlogModule.blog', 'Поблема при выполнении запроса.');?></b></div></div>");
                    }
                },
                error: function(data) {
                    console.log(data);
                    if (typeof data.data != 'undefined') {
                        var type = data.result ? 'success' : 'error';
                        var message = data.result ? data.data.message : data.data;
                        $(link).parents('.view').before("<div class='flash'><div class='flash-" + type + "'><b>" + message + "</b></div></div>");
                        if (data.result)
                            $(link).parents('.view').replaceWith(data.data.content);
                    } else {
                        $(link).parents('.view').before("<div class='flash'><div class='flash-error'><b><?php echo Yii::t('BlogModule.blog', 'Поблема при выполнении запроса.');?></b></div></div>");
                    }
                }
            });
            setTimeout(function(){
                $('.flash').remove();
            }, 3000);
        });
    });
</script>

<?php
$this->widget(
    'zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    )
); ?>