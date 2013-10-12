<section class="row">
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('yupe','Links'); ?></li>
            <li><a href="https://twitter.com/yupecms" target="_blank"><?php echo Yii::t('yupe','Twitter'); ?></a></li> <!--<i class="icon-twitter">-->
            <li><a href="http://vk.com/amylabs" target="_blank"><?php echo Yii::t('yupe','Vk.com'); ?></a></li> <!--<i class="icon-vk"></i>-->
            <li><a href="https://www.facebook.com/amylabs.ru" target="_blank"><?php echo Yii::t('yupe','Facebook'); ?></a></li> <!--<i class="icon-facebook"></i>-->
            <li><a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts" target="_blank"><?php echo Yii::t('yupe','Google+'); ?></a></li> <!--<i class="icon-google-plus"></i>-->
            <li><a href="http://yupe.ru/blog/yupe-mini-cms-yii" target="_blank"><?php echo Yii::t('yupe','Blog'); ?></a></li>
            <li><a href="http://yupe.ru/" target="_blank"><?php echo Yii::t('yupe','Our site'); ?></a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('yupe','Support'); ?></li>
            <li><a href="http://yupe.ru/docs/index.html" target="_blank"><?php echo Yii::t('yupe','Documentation'); ?></a></li>
            <li><a href="http://api.yupe.ru/" target="_blank"><?php echo Yii::t('yupe','API'); ?></a></li>
            <li><a href="http://yupe.ru/talk/" target="_blank"><?php echo Yii::t('yupe','Forum'); ?></a></li>
            <li><a href="http://yupe.ru/feedback/faq/" target="_blank"><?php echo Yii::t('yupe','FAQ'); ?></a></li>
            <li><a href="http://yupe.ru/feedback/index/" target="_blank"><?php echo Yii::t('yupe','Contacts'); ?></a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('yupe','Yupe!'); ?></li>
            <li><a href="http://yupe.ru/pages/about/" target="_blank"><?php echo Yii::t('yupe','About project'); ?></a></li>
            <li><a href="http://yupe.ru/docs/yupe/team.html" target="_blank"><?php echo Yii::t('yupe','Team'); ?></a></li>
            <li><a href="https://github.com/yupe/yupe/" target="_blank"><?php echo Yii::t('yupe','GitHub'); ?></a></li>
            <li><a href="https://github.com/yupe/yupe-ext/" target="_blank"><?php echo Yii::t('yupe','Extensions'); ?></a></li>
            <li><a href="http://yupe.ru/docs/yupe/capability.html" target="_blank"><?php echo Yii::t('yupe','Facilities'); ?></a></li>
            <li><a href="http://yupe.ru/docs/yupe/assistance.project.html" target="_blank"><?php echo Yii::t('yupe','How to help us'); ?></a></li>
        </ul>
    </div>
    <div class="span3">
        <ul class="unstyled">
            <li><?php echo Yii::t('yupe','Friends'); ?></li>
            <li><a href="http://allframeworks.ru" target="_blank"><?php echo Yii::t('yupe','allframeworks'); ?></a></li>
            <li><a href="http://amylabs.ru" target="_blank"><?php echo Yii::t('yupe','amyLabs'); ?></a></li>
            <li><a href="http://yupe.ru/feedback/index/" target="_blank"><?php echo Yii::t('yupe','Do you want to be our friend?'); ?></a></li>
            <li><a href="http://amylabs.ru/contact?from=yupe" target="_blank"><?php echo Yii::t('yupe','Commertial support'); ?></a></li>
        </ul>
    </div>
</section>
<hr>
<footer class="row">
    <div class="span8">
        <?php echo CHtml::link(
                            Yii::t('yupe','Internet projects development and maintenance'),
                            'http://amylabs.ru?from=yupe'
                            ); ?>
    </div>
    <div class="span4">
        <p class="muted pull-right">© 2009 - <?php echo date('Y'); ?> <?php echo CHtml::link(
                                            'amyLabs',
                                            'http://amylabs.ru?from=yupe'
                                            ); ?> && <?php echo Yii::t("yupe","Yupe! team") ?> <?php echo Yii::app()->getModule('yupe')->poweredBy(); ?>
        </p>
    </div>
</footer>
