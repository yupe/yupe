<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#post-updatecomments', function(){
            var link = $(this);
            link.addClass('ajax-loading');
            $.ajax({
                url: '<?php echo Yii::app()->baseUrl;?>/comment/comment/updatecomments',
                data: {'<?php echo Yii::app()->request->csrfTokenName ?>':'<?php echo Yii::app()->request->csrfToken;?>','model':'<?php echo $this->model?>','modelId':'<?php echo $this->modelId;?>'},
                dataType: 'json',
                type: 'post',
                success: function(data){
                    if (data.result && data.data.content) {
                        $('#comments').replaceWith(data.data.content);
                        $('#comments').before(
                            "<div class='flash'><div class='flash-success'><b>" + data.data.message + "</b></div></div>"
                        );
                    } else {
                        $('.comments').before("<div class='flash'><div class='flash-error'><b>" + data.data.message + "</b></div></div>");
                    }
                    link.removeClass('ajax-loading');
                }
            });
            setTimeout(function(){
                $('.flash').remove();
            }, 3000);
            return false;
        });
    });
</script>


<?php
/**
 * Отображение для CommentsListWidget/commentslistwidget:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
if (!$this->comment)
    echo '<div id="comments">';

if (count($comments)) {
    if (!$this->comment)
        echo '<b> ' . $this->label . ' ' . count($comments) . '</b> <a href="#" id="post-updatecomments" title="Обновить комментарии"><i class="icon-repeat"></i></a> '.CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/web/images/rss.png'),array('/comment/rss/feed','model' => $this->model, 'modelId' => $this->modelId));
    foreach ($comments as &$comment) {
        if (!$this->comment && is_object($comment))
        {
            $level = $comment->level-2;
        }else{
            $comment = $this->comment;
            $level = 1;
        }

        echo '<div style="margin-left: ' . (20 * $level) . 'px; " level="' . $level . '">' . "\n";
        echo ''
            . '<div class="well well-small" id="comment_'
            . $comment->id
            . '_'
            . str_replace(' ', '_', $comment->creation_date)
            . '">'
            . "\n"
            . '<div class="avatar">'
            . (!is_object($comment->author)
                         ? CHtml::image(
                            User::model()->getAvatar(32),
                            $comment->name,
                            array(
                                'width' => 32,
                                'height' => 32
                            )
                        )
                         : CHtml::image(
                            $comment->author->getAvatar(32),
                            $comment->author->nick_name,
                            array(
                                'width' => 32,
                                'height' => 32
                            )
                        )
            )
            . '</div>'
            . '<div class="comment-body">'
            . '<div class="author">'
            . "\n";
        if (!is_object($comment->author)) {
            if ($comment->url)
                echo CHtml::link($comment->name, $comment->url);
            else
                echo $comment->name;
        } else
            echo CHtml::link(
                $comment->name,
                array(
                    '/user/people/userInfo/',
                    'username' => $comment->author->nick_name
                )
            );
        echo ' ' . Yii::t('comment', 'написал') . ':';
        echo ''
            . '<span style="float: right">'
            . CHtml::link(
                Yii::t('comment', '<i class="icon-bullhorn"></i>'), 'javascript:void(0);', array(
                    'rel'     => $comment->id,
                    'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                    'class'   => 'commentParrent',
                    'title'   => Yii::t('comment','Ответить')
                )
            )
            . '</span>';
        echo '</div>';
        echo '<div class="time">' . $comment->creation_date . '</div>';
        echo '<div class="content">' . $comment->text . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>' . $this->label . ' ' . Yii::t('comment', 'пока нет, станьте первым!') . '</p>';
}
if (!$this->comment)
    echo '</div>';