<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/"><?php echo Yii::app()->name; ?></a>
          <div class="nav-collapse">
            <ul class="nav">
                <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Главная'), array("/" . Yii::app()->defaultController . "/index")); ?></li>
                <li><?php echo CHtml::link(Yii::t('PageModule.page', 'О проекте'), array('/site/page/', 'view' => 'about')); ?></li>

                <?php if (!Yii::app()->user->isAuthenticated()): ?>
                    <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Войти'), array('/login/')); ?></li>
                <?php else: ?>
                    <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Выйти') . '(' . Yii::app()->user->getState('nick_name') . ')', array('/logout/')); ?></li>
                <?php endif; ?>

                <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Пользователи'), array('/user/people/')); ?></li>

                <?php if (!Yii::app()->user->isAuthenticated()): ?>
                    <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Регистрация'), array('/registration/')); ?></li>
                <?php endif; ?>

                <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Социальные виджеты'), array('/site/social/')); ?></li>
                <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Помощь проекту'), array('/site/page/view/help/')); ?></li>
                <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Контакты'), array('/feedback/contact/')); ?></li>

                <?php foreach ($pages as $page): ?>
                    <li><?php echo CHtml::link($page->name, array("/pages/{$page->slug}")); ?></li>
                <?php endforeach; ?>

                <?php if (Yii::app()->user->isSuperUser()): ?>
                    <li><?php echo CHtml::link(Yii::t('PageModule.page', 'Панель управления'), array('/yupe/backend/')); ?></li>
                <?php endif; ?>
            </ul>
        </div>
      </div>
    </div>
</div>