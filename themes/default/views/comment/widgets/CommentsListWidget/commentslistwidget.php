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
        echo '<b> ' . $this->label . ' ' . count($comments) . '</b>';
    foreach ($comments as &$commentArray) {
        if (!$this->comment && isset($commentArray['childOf'])) {
            $comment = &$commentArray['row'];
            $level = count($commentArray['childOf']);
        } else {
            $comment = $this->comment;
            $level = 1;
        }
        echo '<div style="margin-left: ' . (20 * $level) . 'px; " level="' . $level . '">' . "\n";
        echo ''
            . '<div class="comment" id="comment_'
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
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>' . $this->label . ' ' . Yii::t('comment', 'пока нет, станьте первым!') . '</p>';
}
if (!$this->comment)
    echo '</div>';