<?php
/**
 * Отображение для blog/index:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
Yii::app()->clientScript->registerScript(
    "ajaxToken", "var ajaxToken = " . json_encode(
        Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken
    ) . ";", CClientScript::POS_BEGIN
);
$this->pageTitle = Yii::t('blog', 'Блоги');
$this->breadcrumbs = array(Yii::t('blog', 'Блоги'));
?>

<h1>Блоги <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/');?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/web/images/rss.png" alt="Подпишитесь на обновления" title="Подпишитесь на обновления"></a></h1>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on("click", 'a.get-members', function (event) {
            var blogId = $(this).attr('rel');
            var link = this;
            if ((members = $('.members-' + blogId)).length > 0) {
                members.remove();
                return false;
            } else
                $(link).addClass('ajax-loading');
            $.ajax({
                url: baseUrl + "/blog/blog/people",
                data: ajaxToken + '&blogId=' +blogId,
                dataType: 'json',
                type: 'post',
                success: function(data) {
                    $(link).removeClass('ajax-loading');
                    $(link).after('<div class="members-' + blogId + ' ' + (data.result ? '' : 'error') + '">' + data.data + "</div>");
                },
                error: function(data) {
                    $(link).removeClass('ajax-loading');
                    $(link).after('<div class="members-' + blogId + ' ' + (data.result ? '' : 'error') + '">' + data.data + "</div>");
                }
            });
        });
        $(document).on("click", '.get-posts-list', function (event) {
            event.preventDefault();
            var link = $(this);
            var blogId = link.attr('rel');
            if ((posts = $('.posts-' + blogId)).length > 0) {
                posts.remove();
                return false;
            } else {
                link.addClass('ajax-loading');
            }

            $.ajax({
                url: link.attr('href'),
                data: ajaxToken + '&blogId=' + blogId,
                dataType: 'json',
                type: 'post',
                success: function(data) {
                    link.removeClass('ajax-loading');
                    link.parents('.blog-stats').after('<div class="posts-' + blogId + ' ' + (data.result ? '' : 'error') + '">' + data.data + "</div>");
                },
                error: function(data) {
                    link.removeClass('ajax-loading');
                    link.parents('.blog-stats').after('<div class="posts-' + blogId + ' ' + (data.result ? '' : 'error') + '">' + data.data + "</div>");
                }
            });
        });
        $(document).on("click", 'a.action-blog', function (event) {
            event.preventDefault();
            var blogId = parseInt($(this).attr('rel'));
            var url = $(this).attr('type');
            var link = this;
            $(link).addClass('ajax-loading');
            $.ajax({
                url: baseUrl + '/blog/blog/' + url + '/',
                data: ajaxToken + '&blogId=' +blogId,
                dataType: 'json',
                type: 'post',
                success: function(data) {
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