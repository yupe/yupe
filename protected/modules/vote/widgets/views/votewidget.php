<script type='text/javascript'>
  $(document).ready(function(){
      var model   = '<?php echo $this->model;?>';
      var modelId = '<?php echo $this->modelId;?>';
      $('a.vote').click(function(event){
         event.preventDefault();
         var value   = $(this).attr('id');
         $.post(baseUrl + '/index.php/vote/vote/addVote/',{'modelType':model,'modelId':modelId,'value':value},function(response){
            response.result ? $('#votes').html('Ваша оценка: <b>' + value + '</b> спасибо за голос!') : alert(response.data);
         },'json');
      });
  });
</script>

<div id='votes'>
    <?php if(!is_null($model)):?>
     <p><?php echo Yii::t('vote','Ваша оценка');?>: <b><?php echo $model->value;?></b></p>
    <?php else:?>
     <p>
        <?php echo Yii::t('vote','Оцените изображение');?>:    
        <?php foreach(range(1,5) as $p):?>
           <?php echo CHtml::link($p,array(),array('class' => 'vote','id' => $p));?>
        <?php endforeach;?>
     </p>
    <?php endif;?>
</div>    