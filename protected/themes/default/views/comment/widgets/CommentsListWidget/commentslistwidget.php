<?php
/**
 * Отображение для commentslistwidget:
 *
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
if (count($comments)) {
    /**
     * Отрисовка данной части лишь тогда, когда нулевой уровень:
     **/
    Yii::app()->clientScript->registerScript(
        'commentParrentId', '
        jQuery(document).ready(function($) {
            $(document).on("click", ".del_comment_parrent", function() {
                $(".comment_parrent").remove();
                $("#Comment_parrent_id").val("").removeAttr("value");
            });
            $(document).on("click", ".commentParrent", function() {
                $("#Comment_parrent_id").val($(this).attr("rel"));
                $("#Comment_text").before("<div class=\'row-fluid comment_parrent\'><a style=\'margin-left: 20px;\' href=\'#comment_" + $(this).attr(\'data-id\') + "\'>" + "' . Yii::t('comment', 'комментируем') . ' - ID #' . '" + $(this).attr(\'rel\') + "</a> <a style=\'float:left;\' class=\'del_comment_parrent\' href=\'javascript:void(0);\'> &times; </a></div>").focus();
            });
        });'
    );
    echo '<div id="comments">';
    echo '<h3>' . $this->label . ' : ' . count($comments) . '</h3>';
    echo nestedComment($comments, 0, null);
    echo '</div>';
} else {
    echo '<div id="comments">';
    echo '<p>' . $this->label . ' ' . Yii::t('comment', 'пока нет, станьте первым!') . '</p>';
    echo '</div>';
}

function nestedComment($comments, $level, $parrent_id) {
    foreach ($comments as $comment) {
        if ($parrent_id === $comment->parrent_id) {
            echo '<div style="margin-left: ' . (20 * $level) . 'px; ">' . "\n";
            echo ''
                . '<div class="comment" id="comment_'
                . $comment->id
                . '_'
                . str_replace(' ', '_', $comment->creation_date)
                . '">'
                . "\n"
                . '<div class="author">'
                . "\n";
            if (($author = $comment->getAuthor()) === false) {
                if (strlen($comment->url) > 0)
                    echo CHtml::link($comment->name, $comment->url);
                else
                    echo $comment->name;
            } else
                echo CHtml::link(
                    $comment->name,
                    array(
                        '/user/people/userInfo/',
                        'username' => $author->nick_name
                    )
                );
            echo ' ' . Yii::t('comment', 'написал') . ':';
            echo ''
                . '<span style="float: right">'
                . CHtml::link(
                    Yii::t('comment', 'ответить'), 'javascript:void(0);', array(
                        'rel'     => $comment->id,
                        'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                        'class'   => 'commentParrent',
                    )
                )
                . '</span>';
            echo '</div>';
            echo '<div class="time">' . $comment->creation_date . '</div>';
            echo '<div class="content">' . $comment->text . '</div>';
            echo '</div><!-- comment -->';
            echo nestedComment($comments, $level + 1, $comment->id);
            echo '</div>';
        }
    }
}