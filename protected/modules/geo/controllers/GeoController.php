<?php
class GeoController extends YFrontController
{
    public function actionCityAjax($term)
    {
        $c = new CDbCriteria();

        $c->addCondition("(t.name like :name)");
        $c->params = array(':name' => $term."%");
        $c->limit  = 10;

        $x = array();

        if ($city = GeoCity::model()->with(array('country'))->findAll($c))
        {
            foreach ($city as $u)
            {
                $label = $u->combinedName;
                array_push($x, array(
                    'label' => $label,
                    'value' => $label,
                    'id'    => $u->id,
                ));
            }
        }
        echo json_encode($x);
    }
}