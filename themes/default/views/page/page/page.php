<?php
/**
 * Отображение для page/page:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->pageTitle   = $page->title;
$this->breadcrumbs = $this->breadcrumbs;
$this->description = !empty($page->description) ? $page->description : $this->description;
$this->keywords    = !empty($page->keywords)    ? $page->keywords    : $this->keywords
?>

<h1><?php echo $page->title; ?></h1>

<p><?php echo $page->body; ?></p>