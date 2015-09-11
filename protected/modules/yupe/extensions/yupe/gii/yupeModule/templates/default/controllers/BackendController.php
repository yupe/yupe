<?php echo "<?php\n"; ?>
/**
* <?php echo ucfirst($this->moduleID); ?>BackendController контроллер для <?php echo $this->moduleID; ?> в панели управления
*
* @author yupe team <team@yupe.ru>
* @link http://yupe.ru
* @copyright 2009-<?= date('Y'); ?> amyLabs && Yupe! team
* @package yupe.modules.<?php echo $this->moduleID; ?>.controllers
* @since 0.1
*
*/

class <?php echo ucfirst($this->moduleID); ?>BackendController extends \yupe\components\controllers\BackController
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