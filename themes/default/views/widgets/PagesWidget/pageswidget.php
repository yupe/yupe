<div id="mainmenu">
    <?php
    $menu = array_merge(Menu::model()->getItems('top-menu'), array(
        array(
            'label' => 'Войти',
            'url' => array('/login/'),
            'visible' => !Yii::app()->user->isAuthenticated(),
        ),
        array(
            'label' => 'Выйти (' . Yii::app()->user->getState('nick_name') . ')',
            'url' => array('/logout/'),
            'visible' => Yii::app()->user->isAuthenticated(),
        ),
        array(
            'label' => 'Регистрация',
            'url' => array('/registration/'),
            'visible' => !Yii::app()->user->isAuthenticated(),
        ),
        array(
            'label' => 'Панель управления',
            'url' => array('/yupe/backend/'),
            'visible' => Yii::app()->user->isSuperUser(),
        ),
    ));

    $this->widget('zii.widgets.CMenu', array('items' => $menu));
?>
</div>

<?php/*
<?php foreach ($pages as $page): ?>
    <li><?php echo CHtml::link($page->name, array("/pages/{$page->slug}"));?></li>
<?php endforeach;?>
*/?>