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
    $this->renderPartial(
        'webroot' . str_replace(
            '/', '.', str_replace(
                Yii::getPathOfAlias('webroot'),
                '',
                __DIR__
            )
        ) . '.drawcomments', array(
            'comments'   => $comments,
            'level'      => 0,
            'parrent_id' => null,
        )
    );
    echo '</div>';       
} else {
    echo '<div id="comments">';
    echo '<p>' . $this->label . Yii::t('comment', 'пока нет, станьте первым!') . '</p>';
    echo '</div>';
}