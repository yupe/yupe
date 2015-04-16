<?php
/* @var $comment Comment */
$level = $comment->getLevel()
?>

<div class="comments-item <?php echo $level > 0 ? 'comments-item-child' : '' ?>"
     data-level="<?php echo $level; ?>"
     data-pid="<?php echo $comment->parent_id; ?>"
     data-id="<?php echo $comment->id; ?>"
     style="margin-left: <?php echo(30 * $level); ?>px;">

    <div class="comments-item-main">
        <div class="comments-item-avatar">
            <a href="<?php echo $comment->getAuthorUrl() ?>"><?php echo $comment->getAuthorAvatar(); ?></a>
        </div>
        <div class="comments-item-top">
            <div class="comments-item-author">
                <?php echo $comment->getAuthorLink(); ?>
                <span class='comments-item-date'>
                    <time datetime="<?php echo str_replace(' ', '_', $comment->create_time); ?>">
                        <?php echo Yii::app()->getDateFormatter()->formatDateTime(
                            $comment->create_time,
                            'long',
                            'short'
                        ); ?>
                    </time>
                </span>
            </div>
        </div>
        <div class="comments-item-message">
            <?php echo trim($comment->getText()); ?>
            <div>
                <?php echo CHtml::link(
                    Yii::t('CommentModule.comment', 'reply'),
                    '#',
                    [
                        'rel' => $comment->id,
                        'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->create_time),
                        'class' => 'reply',
                        'title' => Yii::t('CommentModule.comment', 'Reply')
                    ]
                ); ?>
            </div>

        </div>
    </div>
</div>
