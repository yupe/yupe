        <h1>Идет установка модулей</h1>
            <p>
                На данном этапе Юпи постарается установить запрошенные вами модули. Установка может занять некоторое время.
            </p>
        <div id="msg"></div>
        <div class="progress progress-striped active">
            <div class="bar" style="width: 0%;"></div>
        </div>
        <small id="modstate"></small>

<?php

    $this->widget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('install','Журнал установки'),
    'headerIcon' => 'icon-list',
    'content' => '',
    'id'=> 'log-content',
    'htmlOptions' => array('style'=>'margin-top: 20px;font-size: 10px; line-height: 12px;')
    ));
?>
<script type="text/javascript">
    <?php

        // Выясним, какие модули нам нужно постараться поставить первыми
        $morder=array('yupe'=>99999, 'user'=> 99998);
        foreach($modules as $mid=>$m)
                if (!empty($m->dependencies))
                    foreach ($m->dependencies as $d)
                        $morder[$d]=isset($morder[$d])?($morder[$d]+1):1;

        // Отсортируем модули, чтобы по очереди ставились
        uksort($modules,
            function ($a,$b) use ($morder)
            {
                return ( (isset($morder[$a])?$morder[$a]:0) < (isset($morder[$b])?$morder[$b]:0) );
            }
        );

        echo "var total=".count($modules).";\n var modules = {\n";
        foreach ($modules as $m)
            echo "'".$m->id."':{ installed:false, id:\"".$m->id."\", description: ".CJSON::encode($m->name).", icon:'".$m->icon."'},\n";
    echo "\n};";
    ?>

    function log(msg)
    {
        $("#log-content").append(msg.replace("\n","<br/>"));
    }


    var ic=1;
    function setModuleProgress(installed, message)
    {
        $('div.bar').css('width',(total?(installed*100/total):100)+"%");
        $('#msg').html(message);
        $('small#modstate').text(installed + " / " + total);

    }

    function installNext()
    {
        var ic=0;
        $.each(modules, function(i,m) {
            ic++;
            if (!m.installed)
            {
                setModuleProgress(ic,"<i class='icon-"+ m.icon+"'>&nbsp;</i>&nbsp; <?php echo Yii::t('install','Устанавливаем модуль')?> <b>"+m.description+"</b>");
                $.ajax({
                        url:"<?php echo $this->createUrl('/install/default/moduleinstall') ?>",
                        data: { 'name':m.id},
                        dataType: 'json',
                        success: function(data,status){
                                if (typeof(data.installed)!=undefined)
                                {
                                    // установить флаги на пришедших модулях
                                    modules[m.id].installed=true;
                                    if(typeof (data.log)!=undefined)
                                        log(data.log);

                                    setModuleProgress(ic,"<i class='icon-"+ m.icon+"'>&nbsp;</i>&nbsp; <?php echo Yii::t('install','Установлен модуль')?> <b>"+m.description+"</b>");
                                    // проверить, остались ли еще не установленные
                                    if (ic<total)
                                        installNext();
                                    else
                                    {
                                        alert("<?php echo Yii::t('install','Установка модулей успешно завершена!')?> ");
                                        document.location = "<?php echo $this->createUrl('/install/default/createuser/'); ?>"
                                    }

                                }
                        },
                        error: function(e)
                        {
                            log(e.responseText);
                            alert("Ошибка установки модуля");
                        }
                });
                return false;
            }
        });

    }

    $(document).ready( function(){
              setModuleProgress(0,"Начало установки");
              installNext();
        }
    );
</script>
