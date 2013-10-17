<?php
/**
 * TaggableBehaviour
 *
 * Allows to use AR objects as tags.
 *
 * @version 1.5
 * @author 5е-1
 * @link http://code.google.com/p/yiiext/
 */

Yii::import('yupe.extensions.taggable.ETaggableBehavior');

class EARTaggableBehavior extends ETaggableBehavior {
    /**
     * Tag model name
     */
    public $tagModel = 'Tag';
    private $originalTags = array();

    /**
     * Creates tag model
     *
     * @param string $title tag title
     * @return CActiveRecord
     */
    protected function createTag($title) {
        $class = $this->tagModel;
        $tag = new $class();
        $tag->{$this->tagTableName} = $title;
        $tag->save();

        return $tag;
    }

    /**
     * Returns key for caching specific model tags.
     * @return string
     */
    private function getCacheKey() {
        return $this->getCacheKeyBase().$this->getOwner()->primaryKey;
    }
    /**
     * Returns cache key base.
     * @return string
     */
    private function getCacheKeyBase() {
        return 'Taggable'.
            $this->getOwner()->tableName().
            $this->tagTable.
            $this->tagBindingTable.
            $this->tagTableName.
            $this->getModelTableFkName().
            $this->tagBindingTableTagId.
            json_encode($this->scope);
    }

    /**
     * Get model table FK name.
     * @access private
     * @return string
     */
    private function getModelTableFkName() {
        if($this->modelTableFk === null){
            $tableName = $this->getOwner()->tableName();
            $tableName[0] = strtolower($tableName[0]);
            $this->modelTableFk = $tableName.'Id';
        }
        return $this->modelTableFk;
    }

    /**
     * Get tag binding table name.
     * @access private
     * @return string
     */
    private function getTagBindingTableName() {
        if($this->tagBindingTable === null){
            $this->tagBindingTable = $this->getOwner()->tableName().'Tag';
        }
        return $this->tagBindingTable;
    }

    /**
     * If we need to save tags.
     * @access private
     * @return boolean
     */
    private function needToSave() {
        $diff = array_merge(
            array_diff($this->tags, $this->originalTags),
            array_diff($this->originalTags, $this->tags)
        );

        return !empty($diff);
    }

    /**
     * Saves model tags on model save.
     * @param CModelEvent $event
     * @throw Exception
     */
    public function afterSave($event) {
        if($this->needToSave()){

            $builder = $this->getConnection()->getCommandBuilder();

            if(!$this->createTagsAutomatically){
                // checking if all of the tags are existing ones
                foreach($this->tags as $tag){

                    $findCriteria = new CDbCriteria(array(
                        'select' => "t.".$this->tagTablePk,
                        'condition' => "t.{$this->tagTableName} = :tag ",
                        'params' => array(':tag' => $tag),
                    ));
                    if($this->getScopeCriteria()){
                        $findCriteria->mergeWith($this->getScopeCriteria());
                    }
                    $tagId = $builder->createFindCommand(
                        $this->tagTable,
                        $findCriteria
                    )->queryScalar();

                    if(!$tagId){
                        throw new Exception("Tag \"$tag\" does not exist. Please add it before assigning or enable createTagsAutomatically.");
                    }

                }
            }

            if(!$this->getOwner()->getIsNewRecord()){
                // delete all present tag bindings if record is existing one
                $this->deleteTags();
            }

            // add new tag bindings and tags if there are any
            if(!empty($this->tags)){
                foreach($this->tags as $tag){
                    if(empty($tag)) return;

                    // try to get existing tag
                    $findCriteria = new CDbCriteria(array(
                        'select' => "t.".$this->tagTablePk,
                        'condition' => "t.{$this->tagTableName} = :tag ",
                        'params' => array(':tag' => $tag),
                    ));
                    if($this->getScopeCriteria()){
                        $findCriteria->mergeWith($this->getScopeCriteria());
                    }
                    $tagId = $builder->createFindCommand(
                        $this->tagTable,
                        $findCriteria
                    )->queryScalar();

                    // if there is no existing tag, create one
                    if(!$tagId){
                        $tobj = $this->createTag($tag);

                        // reset all tags cache
                        $this->resetAllTagsCache();
                        $this->resetAllTagsWithModelsCountCache();

                        $tagId = $tobj->primaryKey;
                    }

                    // bind tag to it's model
                    $builder->createInsertCommand(
                        $this->getTagBindingTableName(),
                        array(
                            $this->getModelTableFkName() => $this->getOwner()->primaryKey,
                            $this->tagBindingTableTagId => $tagId
                        )
                    )->execute();
                }
                $this->updateCount(+1);
            }


            $this->cache->set($this->getCacheKey(), $this->tags);
        }

        parent::afterSave($event);
    }
}