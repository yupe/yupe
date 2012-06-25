		<div class="language">
                    <ul>
                    <?php
                        $currentLanguage = Yii::app()->language;
                        $cp = Yii::app()->urlManager-> getCleanUrl(Yii::app()->request->getPathInfo());
                        $yupe = Yii::app()-> getModule("yupe");
                        foreach ( explode(",",$yupe->availableLanguages)  as $lang )
                        {
                           $name =mb_convert_case( Yii::app()->locale-> getLocaleDisplayName($lang), MB_CASE_TITLE, 'UTF-8');
                           echo CHtml::tag("li").
                                    CHtml::link(
                                            CHtml::tag("i",array('class'=>$lang)).CHtml::closeTag("i").CHtml::tag("span").ucfirst($lang).CHtml::closeTag("i"),
                                            "/".$lang.$cp,
                                            array( 'title'=>$name, 'class'=> ($currentLanguage==$lang)?"active":"")
                                    ).
                                CHtml::closeTag("li");
                        }
                    ?>
		    </ul>
		</div>
