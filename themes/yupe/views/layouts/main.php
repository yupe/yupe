<!doctype html>
<html>
	<head>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta charset="utf-8" />
	    <meta name="language" content="<?php echo Yii::app()->language;?>"/>
	    <meta name="keywords" content="<?php echo $this->keywords;?>"/>
	    <meta name="description" content="<?php echo $this->description;?>"/>
		<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.png"  type="image/x-png" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css?v<?php echo rand(99999,9999999) ?>" />

	    <!--[if IE]>
	                <script>
	                        document.createElement('header');
	                        document.createElement('nav');
	                        document.createElement('section');
	                        document.createElement('article');
	                        document.createElement('aside');
	                        document.createElement('footer');
	                        document.createElement('time');
	                </script>
	     <![endif]-->
	</head>
	<body>
		<section id="overall_wrapper">
			<header>
				<a href="https://github.com/yupe/yupe" id="forkme" rel="nofollow"></a>
				<div class="center_wrapper">
					<nav>
					<?php $this->widget('application.modules.page.widgets.PagesWidget');?>
					</nav>
					<div id="right_btns">
						<a href="#">выход</a>
					</div>
				</div>
			</header>

			<section id="inner">
				<section class="content">
				    <section class="cmenu">
				    <?php
                      $img = CHtml::image(Yii::app()->theme->baseUrl."/images/logo.png") ;
				      if ( "site/index" != $this-> id."/".$this-> action-> id )
				        echo CHtml::link($img,Yii::app()-> homeUrl, array( 'title'=> Yii::t("main","На главную")) );
				      else
				        echo $img;
                    ?>
                    <ul>
                    <?php

				      $cmenu = array (
				                     array ( 'title'=> 'Записи', 'url'=> array('/site/index') ),
				                     array ( 'title'=> 'Блоги',  'url'=> array('/blog/index') ),
				                     array ( 'title'=> 'Люди',   'url'=> array('/user/people/index') ),
				                     );

				        $l = strlen($cp =  ($this-> module?('/'.$this-> module-> id):'').'/'.$this-> id."/".$this-> action-> id);

				        foreach ( $cmenu as $mi)
				           if ( substr($mi['url'][0],0,$l)==$cp )
				            echo "<li class='active'><span>".$mi['title']."</span></li>";
				           else
				            echo "<li>".CHtml::link($mi['title'],$mi['url'])."</li>";
				      ?>
				      </ul>
				    </section>
				<?php echo $content; ?>
				</section>
				<aside>

					<section id="search_box">
						<form action="#">
							<input type="text" value="поиск в записях" name="s" onfocus="this.value = (this.value == 'поиск в записях') ? '' : this.value" onblur="this.value = (this.value == '') ? 'поиск в записях' : this.value"  />
							<input type="submit" value="" title="Начать поиск" />
						</form>
					</section>
					<section id="tags_cloud" class="rblock">
						<h3>ОБЛАКО МЕТОК</h3>
						<p>
							<a  href="#" class="s1">ajax</a>
							<a  href="#" class="s1">allframeworks</a>
							<a  href="#" class="s1">book</a>
							<a  href="#" class="s2">cms</a>
							<a  href="#" class="s4">codeigniter</a>
							<a  href="#" class="s1">cctp</a>
							<a  href="#" class="s4">db</a>
							<a  href="#" class="s1">eee</a>
							<a  href="#" class="s1">pc</a>
							<a  href="#" class="s8">Firebug</a>
							<a  href="#" class="s3">framework</a>
							<a  href="#" class="s5">fun</a>
							<a  href="#" class="s1">ajax</a>
							<a  href="#" class="s1">allframeworks</a>
							<a  href="#" class="s1">book</a>
							<a  href="#" class="s2">cms</a>
							<a  href="#" class="s4">codeigniter</a>
							<a  href="#" class="s1">cctp</a>
							<a  href="#" class="s4">db</a>
							<a  href="#" class="s1">pc</a>
							<a  href="#" class="s5">fun</a>							<a  href="#" class="s1">ajax</a>
							<a  href="#" class="s1">allframeworks</a>
							<a  href="#" class="s1">book</a>
							<a  href="#" class="s2">cms</a>
							<a  href="#" class="s1">cctp</a>
							<a  href="#" class="s4">db</a>
							<a  href="#" class="s1">pc</a>
							<a  href="#" class="s8">Firebug</a>
							<a  href="#" class="s3">framework</a>
							<a  href="#" class="s5">fun</a>
						</p>
					</section>
					<?php $this->widget('application.modules.comment.widgets.LastCommentsWidget');?>
					<section id="last_records" class="rblock">
						<h3>ПОСЛЕДНИЕ ЗАПИСИ</h3>
						<p>
							<a href="#">Как заставить работать расширения yii-user и rights совместно?</a>
							<a href="#">MVC такой MVC =)</a>
							<a href="#">Жаль, что не верстальщик ... Я кстати тоже ;)</a>
							<a href="#">Как заставить работать расширения yii-user и rights совместно?</a>
							<a href="#">MVC такой MVC =)</a>
							<a href="#">Жаль, что не верстальщик ... Я кстати тоже ;)</a>
						</p>
					</section>
				</aside>
			</section>
			<div id="footer-guardian"><!-- --></div>
		</section>
		<footer>
			<div class="center_wrapper">
				<nav>
					<a href="#">О проекте</a>&nbsp;/&nbsp;
					<a href="#">Документация</a>&nbsp;/&nbsp;
					<a href="#">Модули</a>&nbsp;/&nbsp;
					<a href="#">Сообщество</a>&nbsp;/&nbsp;
					<a href="#">Разработка</a> <br />
					<div>&copy; 2009-2012 Юпи! Powered by Yii</div>

				</nav>
				<section class="logos">
					<a href="http://twitter.com/#yupi"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/twitter.png" title="Yupe! В твиттере" alt="Yupe! В твиттере" /></a>
					<a href="http://twitter.com/#yupi"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/rss.png" title="Yupe! RSS-поток" alt="Yupe! RSS-поток" /></a>
					<a href="https://github.com/yupe/yupe"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/github.png" title="Yupe! На GitHub" alt="Yupe! На GitHub" /></a>
				</section>

			</div>
		</footer>
	</body>
</html>