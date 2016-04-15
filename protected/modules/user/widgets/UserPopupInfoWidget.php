<?php
/**
 * Виджет для вывода popup-информации о пользователе:
 *
 * @author    AKulikiv <im@kulikov.im>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.user.widgets
 */

Yii::import('application.modules.user.models.User');

class UserPopupInfoWidget extends yupe\widgets\YWidget
{
    public $model = null;
    public $view = 'user-popup-info';

    public function run()
    {
        if ($this->model === null || $this->model instanceof User === false) {
            return null;
        }

        $this->render($this->view, ['model' => $this->model]);
    }
}
