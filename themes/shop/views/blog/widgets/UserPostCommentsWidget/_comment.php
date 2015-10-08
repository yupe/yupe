<?php $comment = $data; ?>
<div class="profile-comment">
    <div class="row">
        <div class="col-md-2">
            <div class="post-link">
                <?= CHtml::link($comment->post->title, $comment->post->getLink()); ?>
                <span class="count">
                    <?= $comment->post->commentCount; ?>
                </span>
            </div>
        </div>
        <div class="col-md-10">
            <div class="comments-item">
                <div class="comments-item-main">
                    <div class="comments-item-avatar">
                        <a href="<?= $comment->getAuthorUrl() ?>"><?= $comment->getAuthorAvatar(); ?></a>
                    </div>
                    <div class="comments-item-top">
                        <div class="comments-item-author">
                            <?= $comment->getAuthorLink(); ?>
                            <span class='comments-item-date'>
                                <time datetime="<?= str_replace(' ', '_', $comment->create_time); ?>">
                                    <?= Yii::app()->getDateFormatter()->formatDateTime($comment->create_time, "long", "short"); ?>
                                </time>
                            </span>
                            <span class="comment-link">
                                <?= CHtml::link('#', $comment->post->getUrl(['#' => 'comment-' . $comment->id])) ?>
                            </span>
                        </div>
                    </div>
                    <div class="comments-item-message">
                        <?= trim($comment->getText()); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


