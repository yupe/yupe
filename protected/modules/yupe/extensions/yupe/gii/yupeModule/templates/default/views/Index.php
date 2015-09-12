<?php echo "<?php\n"; ?>
/**
* Отображение для <?php echo $this->moduleID; ?>/index
*
* @category YupeView
* @package  yupe
* @author   Yupe Team <team@yupe.ru>
* @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
* @link     http://yupe.ru
**/
$this->pageTitle = Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>');
$this->description = Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>');
$this->keywords = Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>');

$this->breadcrumbs = [Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>')];
?>

<h1>
    <small>
        <?php echo "<?php"; ?> echo Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>'); ?>
    </small>
</h1>