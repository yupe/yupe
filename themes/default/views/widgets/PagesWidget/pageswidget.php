<div id="mainmenu">
    <ul id="yw0">
        <li><?php echo CHtml::link('Главная', '/' . Yii::app()->defaultController);?></li>

        <li><?php echo CHtml::link('О проекте', array('/site/page/', 'view' => 'about'));?></li>

        <?php if (!Yii::app()->user->isAuthenticated()): ?>
        <li><?php echo CHtml::link('Войти', array('/login/'));?></li>
        <?php else: ?>
        <li><?php echo CHtml::link('Выйти(' . Yii::app()->user->getState('nick_name') . ')', array('/logout/'));?></li>
        <?php endif;?>

        <li><?php echo CHtml::link('Пользователи', array('/user/people/'));?></li>
        <?php if (!Yii::app()->user->isAuthenticated()): ?>
        <li><?php echo CHtml::link('Регистрация', array('/registration/'));?></li>
        <?php endif;?>
        <li><?php echo CHtml::link('Социальные виджеты', array('/site/social/'));?></li>
        <li><?php echo CHtml::link('Помощь проекту', array('/site/page/view/help/'));?></li>
        <li><?php echo CHtml::link('Контакты', array('/feedback/contact/'));?></li>


        <?php foreach ($pages as $page): ?>
            <li><?php echo CHtml::link($page->name, array("/pages/{$page->slug}"));?></li>
        <?php endforeach;?>

        <?php if (Yii::app()->user->isSuperUser()): ?>
        <li><?php echo CHtml::link('Панель управления', array('/yupe/backend/'));?></li>
        <?php endif;?>
    </ul>
</div>








