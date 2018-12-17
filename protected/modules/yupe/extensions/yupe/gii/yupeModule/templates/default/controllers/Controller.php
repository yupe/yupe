<?=  "<?php\n"; ?>
/**
* <?=  ucfirst($this->moduleID); ?>Controller контроллер для <?=  $this->moduleID; ?> на публичной части сайта
*
* @author yupe team <team@yupe.ru>
* @link https://yupe.ru
* @copyright 2009-<?= date('Y'); ?> amyLabs && Yupe! team
* @package yupe.modules.<?=  $this->moduleID; ?>.controllers
* @since 0.1
*
*/

class <?=  ucfirst($this->moduleID); ?>Controller extends \yupe\components\controllers\FrontController
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