<?php
/**
 * Отображение для blog/_people:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
foreach ($members as $member) : 
    echo CHtml::link(
        CHtml::encode(
            $member->fullName
        ), array(
            '/user/people/userInfo/',
            'username' => $member->nick_name,
        )
    ) . '&nbsp';
endforeach; ?>