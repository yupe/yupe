<h1><?php echo Yii::t('install', 'Поздравляем, установка Юпи! завершена!');?></h1>

<p><?php echo Yii::t('install', 'Ваш сайт готов к работе!');?></p>

<p><?php echo Yii::t('install', 'Если Вам не жалко - отправьте нам чуть-чуть денежек, мы будем довольны =) !');?></p>

<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?uid=41001846363811&amp;default-sum=100&amp;targets=%d0%a0%d0%b0%d0%b7%d0%b2%d0%b8%d1%82%d0%b8%d0%b5&amp;target-visibility=on&amp;project-name=%d0%ae%d0%bf%d0%b8!+-+%d0%bc%d0%b8%d0%bd%d0%b8+cms+%d0%bd%d0%b0+yii&amp;project-site=http%3a%2f%2fyupe.ru&amp;button-text=01&amp;comment=on&amp;hint=&amp;fio=on" width="450" height="191"></iframe>

<br/><br/>

<?php echo CHtml::link(Yii::t('install', 'ПЕРЕЙТИ В ПАНЕЛЬ УПРАВЛЕНИЯ'), array('/yupe/backend/')); ?>

<br/><br/>

<p><?php echo Yii::t('install', 'Полезные ссылки:');?></p>

<?php echo CHtml::link(Yii::t('install','Официальный сайт Юпи!'),'http://yupe.ru');?> - <?php echo Yii::t('install','заходите чаще =)');?>

<br/><br/>

<?php echo CHtml::link(Yii::t('install','Официальный твиттер Юпи!'),'https://twitter.com/#!/YupeCms');?>  - <?php echo Yii::t('install','обязательно заффоловьте нас, мы не спамим =)');?>

<br/><br/>

<?php echo CHtml::link(Yii::t('install','Исходный код на Github'),'http://github.com/yupe/yupe/');?> - <?php echo Yii::t('install','пришлите нам парочку пулл-реквестов, все только выиграют =)');?>

<br/><br/>

<?php echo CHtml::link(Yii::t('install','Задайте вопрос на форуме'),'http://talk.allframeworks.ru/categories/yupe-yii-cms');?>  - <?php echo Yii::t('install','заходите, поболтаем =)');?>

<br/><br/>

<?php echo Yii::t('install','Напишите нам на <b>team@yupe.ru</b>');?>  - <?php echo Yii::t('install','принимаем всякого рода коммерческие и любые предложения =)');?>