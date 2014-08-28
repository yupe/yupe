<div class="comments-item <?php echo $level == 0 ? '' : 'comments-item-child' ?>"
     style="margin-left: <?php echo(30 * $level); ?>px;">
    <div class="comments-item-main" id="comment-<?php echo $comment->id; ?>" level="<?php echo $level; ?>">
        <div class="comments-item-avatar">
            <a href="<?php echo $comment->getAuthorUrl() ?>"><?php echo $comment->getAuthorAvatar(); ?></a>
        </div>
        <div class="comments-item-top">
            <div class="comments-item-author">
                <?php echo $comment->getAuthorLink(); ?>
            </div>
            <div class="comments-item-date">
                <time datetime="<?php echo str_replace(' ', '_', $comment->creation_date); ?>"><?php echo Yii::app(
                    )->getDateFormatter()->formatDateTime($comment->creation_date, "long", "short"); ?></time>
            </div>
        </div>
        <div class="comments-item-message">
            <?php echo trim($comment->getText()); ?>
            <div>
                <?php echo CHtml::link(
                    Yii::t('CommentModule.comment', 'reply'),
                    'javascript:void(0);',
                    array(
                        'rel'     => $comment->id,
                        'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                        'class'   => 'reply',
                        'title'   => Yii::t('CommentModule.comment', 'Reply')
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>
