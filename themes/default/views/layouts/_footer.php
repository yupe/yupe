<section class="row">
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('default', 'Links'); ?></li>
            <li><a href="https://twitter.com/yupecms" target="_blank"><?php echo Yii::t('default', 'Twitter'); ?></a>
            </li>
            <li><a href="http://vk.com/amylabs" target="_blank"><?php echo Yii::t('default', 'Vk.com'); ?></a></li>
            <li><a href="https://www.facebook.com/amylabs.ru"
                   target="_blank"><?php echo Yii::t('default', 'Facebook'); ?></a></li>
            <li><a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts"
                   target="_blank"><?php echo Yii::t('default', 'Google+'); ?></a></li>
            <li><a href="http://yupe.ru/blog/yupe-mini-cms-yii"
                   target="_blank"><?php echo Yii::t('default', 'Blog'); ?></a></li>
            <li><a href="http://yupe.ru/" target="_blank"><?php echo Yii::t('default', 'Our site'); ?></a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('default', 'Support'); ?></li>
            <li><a href="http://yupe.ru/docs/index.html"
                   target="_blank"><?php echo Yii::t('default', 'Documentation'); ?></a></li>
            <li><a href="http://api.yupe.ru/" target="_blank"><?php echo Yii::t('default', 'API'); ?></a></li>
            <li><a href="http://yupe.ru/talk/" target="_blank"><?php echo Yii::t('default', 'Forum'); ?></a></li>
            <li><a href="http://yupe.ru/feedback/faq/" target="_blank"><?php echo Yii::t('default', 'FAQ'); ?></a></li>
            <li><a href="http://yupe.ru/contacts?from=footer"
                   target="_blank"><?php echo Yii::t('default', 'Contacts'); ?></a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('default', 'Yupe!'); ?></li>
            <li><a href="http://yupe.ru/pages/about/"
                   target="_blank"><?php echo Yii::t('default', 'About project'); ?></a></li>
            <li><a href="http://yupe.ru/docs/yupe/team.html"
                   target="_blank"><?php echo Yii::t('default', 'Team'); ?></a></li>
            <li><a href="https://github.com/yupe/yupe/" target="_blank"><?php echo Yii::t('default', 'GitHub'); ?></a>
            </li>
            <li><a href="https://github.com/yupe/yupe-ext/"
                   target="_blank"><?php echo Yii::t('default', 'Extensions'); ?></a></li>
            <li><a href="http://yupe.ru/docs/yupe/capability.html"
                   target="_blank"><?php echo Yii::t('default', 'Facilities'); ?></a></li>
            <li><a href="http://yupe.ru/docs/yupe/assistance.project.html"
                   target="_blank"><?php echo Yii::t('default', 'How to help us'); ?></a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('default', 'Friends'); ?></li>
            <li><a href="http://allframeworks.ru" target="_blank"><?php echo Yii::t('default', 'allframeworks'); ?></a>
            </li>
            <li><a href="http://amylabs.ru" target="_blank"><?php echo Yii::t('default', 'amyLabs'); ?></a></li>
            <li><a href="http://yupe.ru/contacts?from=footer"
                   target="_blank"><?php echo Yii::t('default', 'Do you want to be our friend?'); ?></a></li>
            <li><a href="http://amylabs.ru/contact?from=yupe"
                   target="_blank"><?php echo Yii::t('default', 'Commertial support'); ?></a></li>
        </ul>
    </div>
</section>
<hr>
<footer class="row">
    <div class="span12">
        <ul class="inline copyright">
            <li>
                <?php echo CHtml::link(
                    Yii::t('default', 'Internet projects development and maintenance'),
                    'http://amylabs.ru?from=yupe'
                ); ?>
            </li>
            <li class="pull-right">
                © 2009 - <?php echo date('Y'); ?> <?php echo CHtml::link(
                    'amyLabs',
                    'http://amylabs.ru?from=yupe'
                ); ?>
                && <?php echo CHtml::link(Yii::t("default", "Yupe! team"), 'http://yupe.ru?from=yupe'); ?> <?php echo Yii::app()->getModule('yupe')->poweredBy(); ?>
            </li>
        </ul>
    </div>
</footer>
