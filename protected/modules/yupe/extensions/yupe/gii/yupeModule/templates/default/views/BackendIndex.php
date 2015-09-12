<?php echo "<?php\n"; ?>
/**
* Отображение для <?php echo $this->moduleID; ?>Backend/index
*
* @category YupeView
* @package  yupe
* @author   Yupe Team <team@yupe.ru>
* @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
* @link     http://yupe.ru
**/
$this->breadcrumbs = [
    Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>') => ['/<?php echo $this->moduleID; ?>/<?php echo $this->moduleID; ?>Backend/index'],
    Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'Index'),
];

$this->pageTitle = Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?> - index');

$this->menu = $this->getModule()->getNavigation();;
?>

<div class="page-header">
    <h1>
        <?php echo "<?php"; ?> echo Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>'); ?>
        <small><?php echo "<?php"; ?> echo Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'Index'); ?></small>
    </h1>
</div>