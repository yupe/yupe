<?
/**
 * @description Базовый шаблон для страниц
 * @pagelayout  page-default 
 */
?>

<?php $this->beginContent('//layouts/main'); ?>
<!-- page content: -->
    <?php echo $content; ?>
<!-- end of page content -->
<?php $this->endContent(); ?>
