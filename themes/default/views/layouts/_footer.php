<section class="row">
    <div class="span3">
        <ul class="unstyled">
            <li>Ресурсы</li>
            <li><a href="https://twitter.com/yupecms" target="_blank"></i> Twitter</a></li> <!--<i class="icon-twitter">-->
            <li><a href="http://vk.com/amylabs" target="_blank"> Вконтакте</a></li> <!--<i class="icon-vk"></i>-->
            <li><a href="https://www.facebook.com/amylabs.ru" target="_blank"> Facebook</a></li> <!--<i class="icon-facebook"></i>-->
            <li><a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts" target="_blank">Google+</a></li> <!--<i class="icon-google-plus"></i>-->
            <li><a href="http://yupe.ru/blog/yupe-mini-cms-yii" target="_blank">Блог</a></li>
            <li><a href="http://yupe.ru/" target="_blank">Сайт</a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li>Поддержка</li>
            <li><a href="http://yupe.ru/docs/index.html" target="_blank">Документация</a></li>
            <li><a href="http://api.yupe.ru/" target="_blank">API</a></li>
            <li><a href="http://yupe.ru/talk/" target="_blank">Форум</a></li>
            <li><a href="http://yupe.ru/wiki/default/pageIndex" target="_blank">Wiki</a></li>
            <li><a href="http://yupe.ru/feedback/faq/" target="_blank">FAQ</a></li>
            <li><a href="http://yupe.ru/feedback/index/" target="_blank">Контакты</a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li>Юпи!</li>
            <li><a href="http://yupe.ru/pages/about/" target="_blank">О проекте</a></li>
            <li><a href="http://yupe.ru/docs/yupe/team.html" target="_blank">Команда</a></li>
            <li><a href="https://github.com/yupe/yupe/" target="_blank">Github</a></li>
            <li><a href="https://github.com/yupe/yupe-ext/" target="_blank">Доп. модули</a></li>
            <li><a href="http://yupe.ru/docs/yupe/capability.html" target="_blank">Возможности</a></li>
            <li><a href="http://yupe.ru/docs/yupe/assistance.project.html" target="_blank">Помощь проекту</a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li>Друзья</li>
            <li><a href="http://allframeworks.ru" target="_blank">allframeworks</a></li>
            <li><a href="http://amylabs.ru" target="_blank">amylabs</a></li>
            <li><a href="http://yupe.ru/feedback/index/" target="_blank">Хочешь в друзья?</a></li>
            <li><a href="http://amylabs.ru/contact?from=yupe" target="_blank">Коммерческая поддержка</a></li>
        </ul>
    </div>
</section>
<hr>
<footer class="row">
    <div class="span8">
        <?php echo CHtml::link(
                            'Разработка и поддержка интернет-проектов',
                            'http://amylabs.ru?from=yupe'
                            ); ?>
    </div>
    <div class="span4">
        <p class="muted pull-right">© 2009 - <?php echo date('Y'); ?> <?php echo CHtml::link(
                                            'amyLabs',
                                            'http://amylabs.ru?from=yupe'
                                            ); ?> && Юпи! team <?php echo Yii::app()->getModule('yupe')->poweredBy(); ?>
        </p>
    </div>
</footer>
