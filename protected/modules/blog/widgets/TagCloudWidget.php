<?php

class TagCloudWidget extends yupe\widgets\YWidget
{
    /**
     * @var int
     */
    public $limit = 50;

    public function run()
    {
        $model = Post::model();

        $criteria = new CDbCriteria();
        $criteria->order = 'count DESC';
        $criteria->limit = $this->limit;

        $criteria->join = sprintf(
            'JOIN `%s` p ON et.%s = p.id AND p.status = %s',
            $model->tableName(),
            $model->modelTableFk,
            $model::STATUS_PUBLISHED
        );

        $this->render('tagsCloud', [
            'tags' => $model->getAllTagsWithModelsCount($criteria)
        ]);
    }
}