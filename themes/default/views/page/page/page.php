<?php
/* @var $page Page */
/* @var $this PageController */

$this->pageTitle   = $page->title;
$this->breadcrumbs = $this->getBreadCrumbs();
$this->description = !empty($page->description) ? $page->description : $this->description;
$this->keywords    = !empty($page->keywords)    ? $page->keywords    : $this->keywords
?>

<h3><?php echo $page->title; ?></h3>

<p><?php echo $page->body; ?></p>