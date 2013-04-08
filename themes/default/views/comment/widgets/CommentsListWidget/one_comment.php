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

if (empty($level))
    $level = $comment->level;

echo '<div style="margin-left: ' . (20 * $level) . 'px; " level="' . $level . '">' . "\n";
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
    if ($comment->url)
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
echo '</div>';
if ($this->comments !== null)
    echo $this->nestedComment($this->comments, $level + 1, $comment->id);
echo '</div>';