<?php $this->pageTitle = Yii::app()->getModule('yupe')->siteName;?>

<h1>Congratulations!</h1>
<p>You just have installed <a href="http://yupe.ru?from=mainpage" target='_blank'>Yupe! CMS</a>! We hope it was simple
    and you haven't got any problems!?</p>
<div class='alert alert-warning'>
    <p><b>If you have questions about development and support - <a href='http://yupe.ru/contacts?from=mainpage-support'
                                                                   target='_blank'>write us</a> !</b></p>

    <p>Read us in <a href='http://twitter.com/yupecms' target='_blank'>twitter</a>, <a href='http://vk.com/amylabs'
                                                                                       target='_blank'>Vk.com</a>, <a
            href="https://www.facebook.com/amylabs.ru" target='_blank'>Facebook</a> or in <a
            href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts" target='_blank'>Google+</a>
    </p>
</div>
<?php if (YII_DEBUG === true) : ?>
    <p class='alert alert-info'>
        If you have noticed that site work slowly - don't panic. It because debug mode is (YII_DEBUG) enabled. If you
        disable it, site will work much more faster.
        No reasons to be worried, when you deploy your site on production server, debug mode will de disabled
        automaticly.
    </p>
<?php endif; ?>

<p> You can start to edit you site from <code>SiteController</code> edition (/protected/controllers/SiteController)</p>
<P> We made some blanks for you, for example, list of posts (from "Blog" module) you can find <?= CHtml::link(
        'here',
        ['/site/main']
    ) ?> (SiteController/actionMain)</P>
<p> For site management, please go to <?= CHtml::link('Control Panel', ['/yupe/backend/']); ?></p>

<p> If you have questions or problems - review this sources:
<ul>
    <li>Our <a href='http://yupe.ru/talk/?from=mainpage'>forum</a></li>
    <li><a href='https://github.com/yupe/yupe/issues'>Github</a></li>
    <li>Our documentation <a href='http://yupe.ru/docs/index.html?from=mainpage'> we are working around it</a></li>
</ul>

<p>Yupe! extensions and widgets repository, you can found here: <a href="https://github.com/yupe/yupe-ext"
                                                                   target="_blank">https://github.com/yupe/yupe-ext</a>
</p>

<p><a href='http://yupe.ru/pages/help?from=mainpage' target='_blank'> Maybe you want to connect us for development our
        project together, or maybe you want to help us?</a></p>

<div class="alert">
    <p>Donate us!</p>

    <p>Yandex money on <b>41001846363811</b></p>
</div>
