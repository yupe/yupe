<?php echo "<?php\n"; ?>
/**
* <?php echo ucfirst($this->moduleID); ?>Controller контроллер для <?php echo $this->moduleID; ?> на публичной части сайта
*
* @author yupe team <team@yupe.ru>
* @link http://yupe.ru
* @copyright 2009-<?= date('Y'); ?> amyLabs && Yupe! team
* @package yupe.modules.<?php echo $this->moduleID; ?>.controllers
* @since 0.1
*
*/

class <?php echo ucfirst($this->moduleID); ?>Controller extends \yupe\components\controllers\FrontController
{
    /**
     * Действие "по умолчанию"
     *
     * @return void
     */
    public function actionIndex()
    {
        $this->render('index');
    }
}