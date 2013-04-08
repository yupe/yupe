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
<div id="comments">
<?php

if (count($this->comments)) {
    echo '<h3> ' . $this->label . ' ' . count($this->comments) . '</h3>';
    echo $this->nestedComment();
} else {
    echo '<p>' . $this->label . ' ' . Yii::t('comment', 'пока нет, станьте первым!') . '</p>';
}
?>
</div>