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
?>
<script type='text/javascript'>
    $(document).ready(function($) {
        $(document).on("click", "a.commentParrent", function() {
            $this = $(this);
            $("div.comment-form").remove();
            var htmlForm = $("#comment-form-wrap").clone();
            htmlForm.addClass("comment-form").show();
            $("#comment-form-wrap").hide();
            $this.parents("div.comment").parent("div").after(htmlForm);
            $("#Comment_level").val(
                parseInt($this.parents("div.comment").parent("div").attr('level')) + 1
            );
            $("#Comment_parent_id").val($this.attr("rel"));
        });
    });
</script>

<div id="comments">
<?php

if (count($this->comments)) {
    echo '<h3> ' . $this->label . ' ' . count($this->comments) . '</h3>';
    echo $this->nestedComment($this->comments);
} else {
    echo '<p>' . $this->label . ' ' . Yii::t('comment', 'пока нет, станьте первым!') . '</p>';
}
?>
</div>