 <?php $this->widget('yupe\widgets\YFlashMessages');?>


<h1>Поздравляем!</h1>
<p>Вы установили <a href="http://yupe.ru?from=mainpage" target='_blank'>Юпи! CMS</a>! Надеемся у Вас не возникло сложностей !?</p>
<div class='alert alert-warning'>
    <p><b>По вопросам разработки и поддержки - <a href='http://yupe.ru/contacts/?from=mainpage-support' target='_blank'>напишите нам</a> !</b></p>
    <p>Читайте нас в <a href='http://twitter.com/yupecms' target='_blank'>twitter</a>, <a href='http://vk.com/amylabs' target='_blank'>Вконтакте</a>, <a href="https://www.facebook.com/amylabs.ru" target='_blank'>Facebook</a> или в <a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts" target='_blank'>Google+</a></p>
</div>
<?php if (YII_DEBUG === true) : ?>
<p class='alert alert-info'>
    Если вы замечаете "замедление" в работе сайта - не волнуйтесь, в большинстве случаев это связано с тем, что включён YII_DEBUG режим, при его отключении скорость будет на порядок выше. Но не стоит волноваться, ведь при переносе на реальный сервер YII_DEBUG отключается автоматически.
</p>
<?php endif; ?>

<p> Начните доработку Вашего сайта с правки <code>SiteController</code> (/protected/controllers/SiteController)</p>
<P> Мы подготовили для Вас некоторые заготовки, например, список постов (модуль "блог") можно посмотреть вот <?php echo CHtml::link('здесь',array('/site/main'))?> (SiteController/actionMain)</P>
<p> Для управления сайтом, пожалуйста, перейдите в <?php echo CHtml::link('панель управления', array('/yupe/backend/')); ?></p>

<p> При возникновении вопросов или проблем - обращайтесь:
	<ul>
		<li>на наш <a href='http://yupe.ru/talk/?from=mainpage'>форум</a></li>
		<li>на <a href='https://github.com/yupe/yupe/issues'>Github</a></li>
		<li>к документации <a href='http://yupe.ru/docs/index.html?from=mainpage'> которая начинает наполняться </a></li>
	</ul>

<p> Репозиторий дополнительных модулей и виджетов для Юпи! <a href="https://github.com/yupe/yupe-ext" target="_blank">https://github.com/yupe/yupe-ext</a></p>

<p><a href='http://yupe.ru/pages/help?from=mainpage' target='_blank'> Возможно, Вы хотите присоединиться к разработке или помочь проекту ?</a></p>

<div class="alert">
    <p>Помоги команде!</p>
    <p>Я.Деньгами на <b>41001846363811</b></p>
</div>