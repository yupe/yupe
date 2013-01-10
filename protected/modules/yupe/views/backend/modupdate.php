<table>
    <tr>
        <th>Название</th>
    </tr>
<?php
    if (isset($updates[$module->id]) && ($updates=$updates[$module->id]))
        foreach($updates as $u)
        {
            echo "<tr><td>".$u."</td></tr>";
        }
?>
</table>
<form action="#" method="post"><input type="submit" value="<?php Yii::t('YupeModule.yupe','Обновить');?>"></form>
