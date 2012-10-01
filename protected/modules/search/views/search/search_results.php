<?php
if ($news)
{
    foreach ($news as $n)
    {
        $d = strtotime($n->date);
        $time = Yii::app()->dateFormatter->formatDateTime($d, null, "short");
        $date = Yii::app()->dateFormatter->formatDateTime($d, "medium", null);

        echo '<div class="post clearfix">';
            echo '<div class="title clearfix">';
                echo '<time>' . $date . (($time != "0:00") ? " в " . $time : "") . "</time>";
                echo CHTml::link(stripslashes($n->title), array("/news/news/show", "title" => $n->alias));
            echo "</div>";
            echo "<div class=\"content\">" . CHtml::decode(stripslashes($n->short_text)) . "</div>";
        echo "</div>";
    }
}
else
    echo "<h1>По данному запросу ничего не найдено</h1>";