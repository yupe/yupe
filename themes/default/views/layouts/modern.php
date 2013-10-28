<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head prefix="og: http://ogp.me/ns#
    fb: http://ogp.me/ns/fb#
    article: http://ogp.me/ns/article#">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
    <meta charset="<?php echo Yii::app()->charset; ?>"/>
    <meta name="keywords" content="<?php echo $this->keywords; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>
    <meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>"/>
    <meta property="og:description" content="<?php echo $this->description; ?>"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

<?php $this->widget('application.modules.menu.widgets.MenuWidget', array('name' => 'top-menu')); ?>

<div class="container">

    <!-- Main hero unit for a primary marketing message or call to action -->

    <div class="hero-unit relative">
        <a href="https://github.com/yupe/yupe" class="forkme" rel="nofollow"></a>
        
        <h1>Yupe!</h1>

        <p>Simple, lightweight and usefull CMS</p>

        <p>Work on Yiiframework, Twitter Bootstrap and jQuery!</p>

        <p>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'label' => 'Download Yupe!',
                'type' => 'primary',
                'size' => 'large',
                'url' => 'https://github.com/yupe/yupe/releases'
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'htmlOptions' => array(
                    'class' => 'btn btn-success'
                ),
                'label' => 'Documentation',
                'type' => 'primary',
                'size' => 'large',
                'url' => 'http://yupe.ru/docs/'
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'htmlOptions' => array(
                    'class' => 'btn btn-info'
                ),
                'label' => 'Screenshots',
                'type' => 'primary',
                'size' => 'large',
                'url' => 'http://yupe.ru/gallery/gallery/list'
            ));
            ?>
        </p>

        <br/>

        <p>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=watch&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=fork&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=follow&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>

            <a href="https://twitter.com/share" class="twitter-share-button" data-via="YupeCms" data-lang="ru"
               data-size="large" data-hashtags="yupe">Tweet</a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>

            <iframe frameborder="0" allowtransparency="true" scrolling="no"
                    src="https://money.yandex.ru/embed/small.xml?uid=41001846363811&amp;button-text=05&amp;button-size=m&amp;button-color=orange&amp;targets=%D0%9D%D0%B0+%D1%80%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5+%D0%AE%D0%BF%D0%B8!&amp;default-sum=100&amp;mail=on"
                    width="auto" height="42"></iframe>
        </p>

        <p>
            <a href="https://scrutinizer-ci.com/g/yupe/yupe/"><img
                    src="https://scrutinizer-ci.com/g/yupe/yupe/badges/quality-score.png?s=7530a908ed160af10407a051474a9064325510cc"
                    alt="Scrutinizer Quality Score" style="max-width:100%;"></a>
            <a href="https://packagist.org/packages/yupe/yupe"><img
                    src="https://poser.pugx.org/yupe/yupe/downloads.png" alt="Total Downloads"
                    style="max-width:100%;"></a>
            <a href="http://depending.in/yupe/yupe"><img src="https://d2xishtp1ojlk0.cloudfront.net/d/1477472"
                                                         alt="Dependencies Status" style="max-width:100%;"></a>
        </p>
    </div>


    <!-- Example row of columns -->
    <div class="row">
        <div class="span4 module-info">
            <h3><i class="icon icon-user"></i> Users Management</h3>

            <p class="muted">
                Registration, authorization, password recovery via email, user profiles.
            </p>

            <p>
                This module provide simple and usefull interface for user management.
            </p>
        </div>

        <div class="span4 module-info">
            <h3><i class="icon icon-file-text"></i> Pages</h3>

            <p class="muted">
                Simple and fast creation static pages such as "About us", "Contacts" and others.
            </p>

            <p>
                You can change WYSIWYG editor which is more comfortable for you, or add new one.
            </p>
        </div>

        <div class="span4 module-info">
            <h3><i class="icon icon-bullhorn"></i> News</h3>

            <p class="muted">
                Publish a news and share information which are interesting for you.
            </p>

            <p>
                Create you own category structure for your news, text on different languages.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="span4 module-info">
            <h3><i class="icon icon-pencil"></i> Blogs</h3>

            <p class="muted">Create your private or public blogs.</p>

            <p>This module make it possible to create blog for any registered user. In can considerably increase
                interactivity of you site.</p>
        </div>
        <div class="span4 module-info">
            <h3><i class="icon icon-comment"></i> Comments</h3>

            <p class="muted">
                You can comment anything with comments module which provide comment trees.
            </p>

            <p>
                This module helps to users take part in conversations on your site.
                They can comment articles, news, photos, videos and more other.
            </p>
        </div>
        <div class="span4 module-info">
            <h3><i class="icon icon-shopping-cart"></i> Catalog</h3>

            <p class="muted">This module can help to create simple and lightweight products catalog for your site.</p>

            <p>For more usefull navigation, you can divide you products by categories and subcategorie, use pages and
                sorting. </p>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <h2>
                <small>last in blogs</small>
            </h2>
            <?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array('limit' => 3, 'view' => 'lastposts-index')); ?>
        </div>
        <div class="span6">
            <h2>
                <small>Our contributors</small>
            </h2>
            <span id="contributors"></span>

            <h2>
                <small>Our twitter</small>
            </h2>
            <div class="widget twitter-widget">
                <a class="twitter-timeline" href="https://twitter.com/YupeCms" data-widget-id="342373817932451841"
                   height="400">
                    @YupeCms tweets
                </a>
            </div>
        </div>
    </div>

    <?php $this->widget('application.modules.gallery.widgets.GalleryWidget', array('limit' => 4, 'galleryId' => 4, 'view' => 'gallery-index')); ?>
    <hr>
    <?php $this->renderPartial('//layouts/_footer'); ?>

</div>
<!-- /container -->

<script type="text/javascript">
    !function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = p + "://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, "script", "twitter-wjs");
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            type: 'GET',
            url: 'https://api.github.com/repos/yupe/yupe/contributors',
            dataType: 'jsonp',
            success: function (data, status) {
                $.each(data.data, function (key, contributor) {
                    var image = "<img src=\"" + contributor.avatar_url + "\" width=\"48\" height=\"48\">";
                    var link = $(document.createElement('a'));
                    link.attr('href', 'https://github.com/' + contributor.login);
                    link.attr('target', "_blank");
                    link.attr('rel', 'tooltip');
                    link.attr('title', contributor.login);
                    link.html(image);
                    $('#contributors').append(link);
                });
            }
        });
    })
</script>
</body>
</html>