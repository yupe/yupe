<p><?php echo Yii::t('social', 'Модуль предназначен для интеграции Вашего сайта и социальных сетей =)'); ?></p>

Виджет для авторизации на сайте:
    <br/>
    <br/>
    <p> $this->widget('application.modules.social.extensions.eauth.EAuthWidget', array('action' => '/social/social/login')); </p>

