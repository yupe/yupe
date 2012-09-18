<?php
class LastNewsWidget extends YWidget
{
    public $count = 5;

    /** @var $categories mixed Список категорий, из которых выбирать новости. NULL - все */
    public $categories = null;

    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->limit = $this->count;
        $criteria->order = 'date DESC';

        if($this->categories)
            if(is_array($this->categories))
                $criteria->addInCondition('category_id',$this->categories);
            else
                $criteria->compare('category_id',$this->categories);

        if ( $this->controller->isMultilang() )
            $news = News::model()->published()->language(Yii::app()->language)->cache($this->cacheTime)->findAll($criteria);
        else
            $news = News::model()->published()->cache($this->cacheTime)->findAll($criteria);

        $this->render('news', array('models' => $news));
    }
}