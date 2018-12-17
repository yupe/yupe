<?=  "<?php\n"; ?>
/**
* <?=  ucfirst($this->moduleID); ?>BackendController контроллер для <?=  $this->moduleID; ?> в панели управления
*
* @author yupe team <team@yupe.ru>
* @link https://yupe.ru
* @copyright 2009-<?= date('Y'); ?> amyLabs && Yupe! team
* @package yupe.modules.<?=  $this->moduleID; ?>.controllers
* @since 0.1
*
*/

class <?=  ucfirst($this->moduleID); ?>BackendController extends \yupe\components\controllers\BackController
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