<?php $this->pageTitle='Блоги';?>

<h1>Блоги</h1>

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

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
