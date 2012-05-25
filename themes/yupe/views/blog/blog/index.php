<?php $this->pageTitle='Блоги';?>
<script type="text/javascript">
    $(document).ready(function(){
        $('a.join-blog').click(function(event){
            event.preventDefault();
            var blogId = parseInt($(this).attr('href'));
               $.post(baseUrl + '/blog/blog/join/',{'blogId':blogId},function(response){
                var type = response.result ? 'success' : 'error';
                   showNotification({message:response.data, type:type, autoClose: true,duration:3});
               },'json');
           });
    });
    </script>

<section class="blogs_list">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

    <div id="head">
        <div class="j"><a href="#" class="add">Читать блог</a></div>
        <div class="r"><a href="#">Рейтинг</a></div>
        <div class="c"><a href="#">Категория</a></div>
        <div class="t"><a href="#" class="active">Блог</a></div>
    </div>
    <div class="blog">
        <div class="j"><a href="#" class="add">Читать блог</a></div>
        <div class="r">471,95</div>
        <div class="c"><a href="#">Железо и гаджеты</a></div>
        <div class="t">
            <div class="h"><a href="#">DIY или Сделай Сам</a></div>
            <div class="p">13464 читателя, 423 поста</div>
        </div>

    </div>
    <div class="blog">
        <div class="j"><a href="#">Покинуть блог</a></div>
        <div class="r">385,00</div>
        <div class="c"><a href="#">Дизайн и юзабилити</a></div>
        <div class="t">
            <div class="h"><a href="#">Иконосказ</a></div>
            <div class="p">1464 читателя, 43 поста</div>
        </div>

    </div>
    <div class="blog">
        <div class="j"><a href="#" class="add">Читать блог</a></div>
        <div class="r">366,30</div>
        <div class="c"><a href="#">Десерт</a></div>
        <div class="t">
            <div  class="h"><a href="#">IT-Биографии</a></div>
            <div  class="p">9069 читателя, 324 поста</div>
        </div>
    </div>

</section>
<nav>
    <ul class="next-prev clearfix">
        <li>← предыдущая</li>
        <li><a href="#" rel="">следующая</a> →</li>
    </ul>
    <ul class="pages">
        <li><div>1</div></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
    </ul>
</nav>