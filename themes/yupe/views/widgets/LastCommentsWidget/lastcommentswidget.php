<section id="last_comments" class="rblock">
	<h3>ПОСЛЕДНИЕ КОММЕНТАРИИ</h3>

<?php
    if ( $comments )
    {
            echo "<dl>";
            foreach ( $comments as $c)
            {
                ?>
				<dt><img width="24" height="24" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/default_avatar_24.png" title="xoma" alt="xoma" /></dt>
				<dd>
					<a href="#" class="nick" rel="author"><?=$c->name; ?></a>&nbsp;&rarr;&nbsp;
					<a href="#" class="blog">Новости</a>
			&mdash; <a href="#" class="topic"><?=$c->text; ?></a>
				</dd>
            <?php
            }
            echo "</dl>";
/*           'id' => Yii::t('comment', 'id'),
            'model' => Yii::t('comment', 'Тип модели'),
            'model_id' => Yii::t('comment', 'Модель'),
            'creation_date' => Yii::t('comment', 'Дата создания'),
            'name' => Yii::t('comment', 'Имя'),
            'email' => Yii::t('comment', 'Email'),
            'url' => Yii::t('comment', 'Сайт'),
            'text' => Yii::t('comment', 'Комментарий'),
            'status' => Yii::t('comment', 'Статус'),
            'verifyCode' => Yii::t('comment', 'Код проверки'),
            'ip' => Yii::t('comment', 'ip'),



							<dt><img width="24" height="24" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/default_avatar_24.png" title="xoma" alt="xoma" /></dt>
							<dd>
								<a href="#" class="nick" rel="author">zhunalov</a>&nbsp;&rarr;&nbsp;
								<a href="#" class="blog">Yii &ndash; php-фреймворк</a>
						&mdash; <a href="#" class="topic">Как заставить работать расширения yii-users и rights совместно?</a>
							</dd>

							<dt><img width="24" height="24" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tsm.jpg" title="archaron" alt="archaron" /></dt>
							<dd>
								<a href="#" class="nick" rel="author">archaron</a>&nbsp;&rarr;&nbsp;
								<a href="#" class="blog">Проблемы верстки</a>
						&mdash; <a href="#" class="topic">Верстка, такая верстка :-D Вся правда.</a>
							</dd>

							<dt><img width="24" height="24" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bender.jpg" title="bender" alt="bender" /></dt>
							<dd>
								<a href="#" class="nick" rel="author">bender</a>&nbsp;&rarr;&nbsp;
								<a href="#" class="blog">Проблемы верстки</a>
						&mdash; <a href="#" class="topic">Необычный баг в Chrome с CSS селектором.</a>
							</dd>
							<dt><img width="24" height="24" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/cat.jpg" title="kitty" alt="kitty" /></dt>
							<dd>
								<a href="#" class="nick" rel="author">kitty</a>&nbsp;&rarr;&nbsp;
								<a href="#" class="blog">DIY или Сделай Сам</a>
						&mdash; <a href="#" class="topic">Термоядерный реактор для чайников.</a>
							</dd>
							<dt><img width="24" height="24" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bobby.jpg" title="bobby" alt="bobby" /></dt>
							<dd>
								<a href="#" class="nick" rel="author">bobby</a>&nbsp;&rarr;&nbsp;
								<a href="#" class="blog">Мир за гранью реальности и понимания.</a>
						&mdash; <a href="#" class="topic">Карама: увеличивать или подождать спада зимниих холодов?</a>
							</dd>

						</dl>
*/
}
?>
</section>
