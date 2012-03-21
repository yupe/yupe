					<article itemscope itemtype="http://schema.org/BlogPosting">
						<?php //echo CHtml::link(CHtml::encode($data->title), array('/news/news/show', 'title' => $data->alias), array("itemprop"=>"blogName",'class'=>'blog'));
						// &nbsp;&mdash;&nbsp;
						?>


						<h2 itemprop="headline"><?php echo CHtml::link(CHtml::encode($data->title), array('/news/news/show', 'title' => $data->alias), array('class'=>"topic", 'itemprop'=>"url")); ?></h2>
						<p itemprop="description">
							<?php echo $data->short_text; ?>
						</p>
						<section>
							<div title="Рейтинг поста" class="rating negative" itemscope itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating"><span itemprop="ratingValue">2</span></div>
							<time itemprop="date"  datetime="<?php echo date("c",strtotime($data->creation_date)); ?>"><?php echo date("d M Y H:i",strtotime($data->creation_date)); ?></time>
							<a href="http://yupe.ru/users/opeykin" itemprop="author" rel="author" class="author nick"><?php echo $data->user->nick_name?></a>

							<div itemprop="keywords" class="keywords">
								<a href="#">yii</a>,
								<a href="#">yii-framework</a>,
								<a href="#">yii-user</a>,
								<a href="#">rights</a>
							</div>
							<a class="comments" href="http://yupe.ru/comments/213" itemprop="comments"><span itemprop="interactionCount">15</span></a>
						</section>
					</article>

<?php

/*
    <div class="nav">
        <?php echo CHtml::link('Постоянная ссылка', array('/news/news/show', 'title' => $data->alias));?>
        | последнее обновление <?php echo $data->change_date;?>
    </div>
*/