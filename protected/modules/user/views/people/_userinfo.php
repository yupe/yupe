<section id='userinfo_about'>
<h2>Личное</h2>
<dl>
	<dt>Пол:</dt>
	<dd><?=$user-> getGender();?></dd>

<?php if ( $user-> birth_date != '0000-00-00' )
{
    ?>
	<dt>Дата рождения:</dt>
	<dd><?=CHtml::encode($user-> birth_date);?></dd>
	<?php
}

if ( $user-> about)
{
    ?>
	<dt>О себе:</dt>
	<dd><?=CHtml::encode($user-> about);?></dd>
	<?php
}

?>
</dl>
<h2>Активность</h2>
<h2>Контакты</h2>


</section>