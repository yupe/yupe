<script type='text/javascript'>
    $(document).ready(function($) {            
        $("a.commentParrent").click(function() {                                
            $this = $(this);
            $("div.comment-form").remove();
            var htmlForm = $("#comment-form-wrap").clone();                
            htmlForm.addClass("comment-form").show();
            $("#comment-form-wrap").hide();
            $this.parents("div.comment").parent("div").after(htmlForm);
            $("#Comment_parrent_id").val($this.attr("rel"));                
        });
    });
</script>

<div id="comments">
<?php if(count($comments)):?>    
    <h3><?php echo $this->label?> <?php echo count($comments);?></h3>
    <?php echo nestedComment($comments, 0, null);?>    
<?php else:?>
    <p><?php echo $this->label;?> <?php echo Yii::t('comment', 'пока нет, станьте первым!');?></p>';
<?php endif;?>
</div>

<?php
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
            if (($author = $comment->getAuthor()) === false && $comment->url) {
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