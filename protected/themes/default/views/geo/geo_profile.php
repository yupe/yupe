   <?php
   $city_id = Yii::app()->request->getParam("GeoProfile[geo_city_id]")?:($model->geo_city_id?:NULL);

   if (!$city_id )
       $guessed_city = Yii::app()->getModule("geo")->guessCity();

   if ($city_id && ($city = GeoCity::model()->with('country')->findByPk($city_id)))
       $city = $city->combinedName;
   else
       $city = "";

    ?>
    <div class="list">
        <div class="name">Город:</div>
        <div class="form">
    <?php
    $form-> widget('zii.widgets.jui.CJuiAutoComplete', array(
        'name'=>'GeoProfile[geo_city]',
        'value'=> $city,
        'sourceUrl'=>$this->createUrl('/geo/geo/cityAjax'),
        'htmlOptions'=>array('class'=>'span5'),
        'options'=> array(
            'showAnim' => 'fold',
            'select' =>'js: function(event, ui) {
             $("#GeoProfile_geo_city_id").val(ui.item.id);
            }',

        )
    ));
    echo CHtml::hiddenField('GeoProfile[geo_city_id]',$city_id);
    if (!$city_id && $guessed_city)
    {
        echo "<br /><small>Мы думаем, что вы из города <a href='#' onClick='$(\"#GeoProfile_geo_city_id\").val(".$guessed_city->id.");$(\"#GeoProfile_geo_city\").val($(this).text());return false;'>".$guessed_city-> combinedName."</a><br />. Кликните по ссылке, чтобы выбрать этот город.</small>";
    }
    ?>

        </div>
        <div class="accession"></div>
    </div>