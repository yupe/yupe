<?php
/**
 * Файл шаблона login:
 *
 * @category YupeLayout
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="icon" type="image/png" href="<?php echo Yii::app()->baseUrl;?>/web/images/favicon.png" />
        <?php
            $mainAssets = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.modules.yupe.views.assets')
            );
            Yii::app()->clientScript->registerCssFile($mainAssets . '/css/styles.css');
        ?>
    </head>
    <body>
        <div id="overall-wrap">
            <?php echo $content; ?>
        </div>
        <footer>
            Copyright &copy; 2009-<?php echo date('Y'); ?>
            <a href='http://yupe.ru?from=blogin'>
                <?php echo $this->yupe->poweredBy();?>
            </a>
        </footer>
    </body>
</html>