<?php
/**
 * ETaggableBehavior class file.
 *
 * @author Alexander Makarov
 * @link http://code.google.com/p/yiiext/
 */
/**
 * Provides tagging ability for a model.
 *
 * @version 1.5
 * @package yiiext.behaviors.model.taggable
 */
class ETaggableBehavior extends CActiveRecordBehavior {
    /**
     * @var string tags table name.
     */
    public $tagTable = 'Tag';
    /**
     * @var string tag table field that contains tag name.
     */
    public $tagTableName = 'name';
    /**
     * @var string tag table PK name.
     */
    public $tagTablePk = 'id';
    /**
     * @var string tag to Model binding table name.
     * Defaults to \"{model table name}Tag\".
     */
    public $tagBindingTable;
    /**
     * @var string binding table tagId name.
     */
    public $tagBindingTableTagId = 'tagId';
    /**
     * @var string|null tag table count field. If null don't uses database.
     */
    public $tagTableCount;
    /**
     * @var string binding table model FK name.
     * Defaults to \"{model table name with first lowercased letter}Id\".
     */
    public $modelTableFk;
    /**
     * @var boolean which create tags automatically or throw exception if tag does not exist.
     */
    public $createTagsAutomatically = true;
    /**
     * @var string|boolean caching component Id. If false don't use cache.
     * Defaults to false.
     */
    public $cacheID = false;

    private $tags = array();
    private $originalTags = array();
    /**
     * @var CDbConnection
     */
    private $_conn;
    /**
     * @var CCache
     */
    protected $cache;
    /**
     * @var array|CDbCriteria default scope criteria. Used as filter in find, load, create or update tags.
     */
    public $scope = array();
    /**
     * @var array these values are added on inserting tag into DB.
     */
    public $insertValues = array();
    /**
     * @var CDbCriteria|null scope CDbCriteria cache.
     */
    private $scopeCriteria = null;

    /**
     * Get DB connection.
     * @return CDbConnection
     */
    protected function getConnection() {
        if(!isset($this->_conn)){
            $this->_conn = $this->getOwner()->dbConnection;
        }
        return $this->_conn;
    }
    /**
     * @throws CException
     * @param CComponent $owner
     * @return void
     */
    public function attach($owner) {
        // Prepare cache component
        if($this->cacheID!==false)
            $this->cache = Yii::app()->getComponent($this->cacheID);
        if(!($this->cache instanceof ICache)){
            // If not set cache component, use dummy cache.
            $this->cache = new CDummyCache;
        }

        parent::attach($owner);
    }
    /**
     * Allows to print object.
     * @return string
     */
    public function toString() {
        $this->loadTags();
        return implode(', ', $this->tags);
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
     * Set one or more tags.
     * @param string|array $tags
     * @return void
     */
    public function setTags($tags) {
        $tags = $this->toTagsArray($tags);
        $this->tags = array_unique($tags);

        return $this->getOwner();
    }
    /**
     * Add one or more tags.
     * @param string|array $tags
     * @return void
     */
    public function addTags($tags) {
        $this->loadTags();

        $tags = $this->toTagsArray($tags);
        $this->tags = array_unique(array_merge($this->tags, $tags));

        return $this->getOwner();
    }
    /**
     * Alias of {@link addTags()}.
     * @param string|array $tags
     * @return void
     */
    public function addTag($tags) {
        return $this->addTags($tags);
    }
    /**
     * Remove one or more tags.
     * @param string|array $tags
     * @return void
     */
    public function removeTags($tags) {
        $this->loadTags();

        $tags = $this->toTagsArray($tags);
        $this->tags = array_diff($this->tags, $tags);

        return $this->getOwner();
    }
    /**
     * Alias of {@link removeTags}.
     * @param string|array $tags
     * @return void
     */
    public function removeTag($tags) {
        return $this->removeTags($tags);
    }
    /**
     * Remove all tags.
     * @return void
     */
    public function removeAllTags() {
        $this->loadTags();
        $this->tags = array();
        return $this->getOwner();
    }
    /**
     * Get default scope criteria.
     * @return CDbCriteria
     */
    protected function getScopeCriteria() {
        if(!$this->scopeCriteria){

            $scope = $this->scope;

            if(is_array($this->scope) && !empty($this->scope)){
                $scope = new CDbCriteria($this->scope);
            }
            if($scope instanceof CDbCriteria){
                $this->scopeCriteria = $scope;
            }
        }
        return $this->scopeCriteria;
    }
    /**
     * Get tags.
     * @return array
     */
    public function getTags() {
        $this->loadTags();
        return $this->tags;
    }
    /**
     * Get current model's tags with counts.
     * @todo: quick implementation, rewrite!
     * @param CDbCriteria $criteria
     * @return array
     */
    public function getTagsWithModelsCount($criteria = null) {
        if(!($tags = $this->cache->get($this->getCacheKey().'WithModelsCount'))){

            $builder = $this->getConnection()->getCommandBuilder();

            if($this->tagTableCount !== null){
                $findCriteria = new CDbCriteria(array(
                    'select' => "t.{$this->tagTableName} as " .Yii::app()->db->getSchema()->quoteTableName('name') . ", t.{$this->tagTableCount} as " .Yii::app()->db->getSchema()->quoteTableName('count'),
                    'join' => "INNER JOIN {$this->getTagBindingTableName()} et on t.{$this->tagTablePk} = et.{$this->tagBindingTableTagId} ",
                    'condition' => "et.{$this->getModelTableFkName()} = :ownerid ",
                    'params' => array(
                        ':ownerid' => $this->getOwner()->primaryKey,
                    )
                ));
            } else{
                $findCriteria = new CDbCriteria(array(
                    'select' => "t.{$this->tagTableName} as " .Yii::app()->db->getSchema()->quoteTableName('name') . ", count(*) as " .Yii::app()->db->getSchema()->quoteTableName('count'),
                    'join' => "INNER JOIN {$this->getTagBindingTableName()} et on t.{$this->tagTablePk} = et.{$this->tagBindingTableTagId} ",
                    'condition' => "et.{$this->getModelTableFkName()} = :ownerid ",
                    'group' => 't.'.$this->tagTablePk,
                    'params' => array(
                        ':ownerid' => $this->getOwner()->primaryKey,
                    )
                ));
            }

            if($criteria){
                $findCriteria->mergeWith($criteria);
            }

            $tags = $builder->createFindCommand(
                $this->tagTable,
                $findCriteria
            )->queryAll();

            $this->cache->set($this->getCacheKey().'WithModelsCount', $tags);
        }

        return $tags;
    }
    /**
     * Get tags array from comma separated tags string.
     * @access private
     * @param string|array $tags
     * @return array
     */
    protected function toTagsArray($tags) {
        if(!is_array($tags)){
            $tags = explode(',', trim(strip_tags($tags), ' ,'));
        }

        array_walk($tags, array($this, 'trim'));
        return $tags;
    }
    /**
     * Used as a callback to trim tags.
     * @access private
     * @param string $item
     * @param string $key
     * @return string
     */
    private function trim(&$item, $key) {
        $item = trim($item);
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
                        $this->createTag($tag);

                        // reset all tags cache
                        $this->resetAllTagsCache();
                        $this->resetAllTagsWithModelsCountCache();

                        $tagId = $this->getConnection()->getLastInsertID();
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
    /**
     * Reset cache used for {@link getAllTags()}.
     * @return void
     */
    public function resetAllTagsCache() {
        $this->cache->delete('Taggable'.$this->getOwner()->tableName().'All');
    }
    /**
     * Reset cache used for {@link getAllTagsWithModelsCount()}.
     * @return void
     */
    public function resetAllTagsWithModelsCountCache() {
        $this->cache->delete('Taggable'.$this->getOwner()->tableName().'AllWithCount');
    }
    /**
     * Deletes tag bindings on model delete.
     * @param CModelEvent $event
     * @return void
     */
    public function afterDelete($event) {
        // delete all present tag bindings
        $this->deleteTags();

        $this->cache->delete($this->getCacheKey());
        $this->resetAllTagsWithModelsCountCache();

        parent::afterDelete($event);
    }

    /**
     * Load tags into model.
     * @params array|CDbCriteria $criteria, defaults to null.
     * @access protected
     * @param null $criteria
     * @return void
     */
    protected function loadTags($criteria = null) {
        if($this->tags != null) return;
        if($this->getOwner()->getIsNewRecord()) return;

        if(!($tags = $this->cache->get($this->getCacheKey()))){

            $findCriteria = new CDbCriteria(array(
                'select' => "t.{$this->tagTableName} as " .Yii::app()->db->getSchema()->quoteTableName('name'),
                'join' => "INNER JOIN {$this->getTagBindingTableName()} et ON t.{$this->tagTablePk} = et.{$this->tagBindingTableTagId} ",
                'condition' => "et.{$this->getModelTableFkName()} = :ownerid ",
                'params' => array(
                    ':ownerid' => $this->getOwner()->primaryKey,
                )
            ));
            if($criteria){
                $findCriteria->mergeWith($criteria);
            }
            if($this->getScopeCriteria()){
                $findCriteria->mergeWith($this->getScopeCriteria());
            }

            $tags = $this->getConnection()->getCommandBuilder()->createFindCommand(
                $this->tagTable,
                $findCriteria
            )->queryColumn();
            $this->cache->set($this->getCacheKey(), $tags);
        }

        $this->originalTags = $this->tags = $tags;
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
     * Get criteria to limit query by tags.
     * @access private
     * @param array $tags
     * @return CDbCriteria
     */
    protected function getFindByTagsCriteria($tags) {
        $criteria = new CDbCriteria();

        $pk = $this->getOwner()->tableSchema->primaryKey;

        if(!empty($tags)){
            $conn = $this->getConnection();
            $criteria->select = 't.*';
            for($i = 0, $count = count($tags); $i < $count; $i++){
                $tag = $conn->quoteValue($tags[$i]);
                $criteria->join .=
                    "JOIN {$this->getTagBindingTableName()} bt$i ON t.{$pk} = bt$i.{$this->getModelTableFkName()}
                    JOIN {$this->tagTable} tag$i ON tag$i.{$this->tagTablePk} = bt$i.{$this->tagBindingTableTagId} AND tag$i." .Yii::app()->db->getSchema()->quoteTableName("{$this->tagTableName}") . " = $tag";
            }
        }

        if($this->getScopeCriteria()){
            $criteria->mergeWith($this->getScopeCriteria());
        }

        return $criteria;
    }
    /**
     * Get all possible tags for current model class.
     * @param CDbCriteria $criteria
     * @return array
     */
    public function getAllTags($criteria = null) {
        if(!($tags = $this->cache->get('Taggable'.$this->getOwner()->tableName().'All'))){
            // getting associated tags
            $builder = $this->getOwner()->getCommandBuilder();
            $findCriteria = new CDbCriteria();
            $findCriteria->select = $this->tagTableName;
            if($criteria){
                $findCriteria->mergeWith($criteria);
            }
            if($this->getScopeCriteria()){
                $findCriteria->mergeWith($this->getScopeCriteria());
            }
            $tags = $builder->createFindCommand($this->tagTable, $findCriteria)->queryColumn();

            $this->cache->set('Taggable'.$this->getOwner()->tableName().'All', $tags);
        }

        return $tags;
    }
    /**
     * Get all possible tags with models count for each for this model class.
     * @param CDbCriteria $criteria
     * @return array
     */
    public function getAllTagsWithModelsCount($criteria = null) {
        if(!($tags = $this->cache->get('Taggable'.$this->getOwner()->tableName().'AllWithCount'))){
            // getting associated tags
            $builder = $this->getOwner()->getCommandBuilder();

            $tagsCriteria = new CDbCriteria();

            if($this->tagTableCount !== null){
                $tagsCriteria->select = sprintf(
                    "t.%s as " .Yii::app()->db->getSchema()->quoteTableName('name') . ", %s as " .Yii::app()->db->getSchema()->quoteTableName('count'),
                    $this->tagTableName,
                    $this->tagTableCount
                );
            }
            else{
                $tagsCriteria->select = sprintf(
                    "t.%s as " .Yii::app()->db->getSchema()->quoteTableName('name') . ", count(*) as \"count\"",
                    $this->tagTableName
                );
                $tagsCriteria->join = sprintf(
                    "JOIN %s et ON t.{$this->tagTablePk} = et.%s",
                    $this->getTagBindingTableName(),
                    $this->tagBindingTableTagId
                );
                $tagsCriteria->group = 't.'.$this->tagTablePk;
            }

            if($criteria!==null)
                $tagsCriteria->mergeWith($criteria);

            if($this->getScopeCriteria())
                $tagsCriteria->mergeWith($this->getScopeCriteria());

            $tags = $builder->createFindCommand($this->tagTable, $tagsCriteria)->queryAll();

            $this->cache->set('Taggable'.$this->getOwner()->tableName().'AllWithCount', $tags);
        }

        return $tags;
    }
    /**
     * Finds out if model has all tags specified.
     * @param string|array $tags
     * @return boolean
     */
    public function hasTags($tags) {
        $this->loadTags();

        $tags = $this->toTagsArray($tags);
        foreach($tags as $tag){
            if(!in_array($tag, $this->tags)) return false;
        }
        return true;
    }
    /**
     * Alias of {@link hasTags()}.
     * @param string|array $tags
     * @return boolean
     */
    public function hasTag($tags) {
        return $this->hasTags($tags);
    }
    /**
     * Limit current AR query to have all tags specified.
     * @param string|array $tags
     * @return CActiveRecord
     */
    public function taggedWith($tags) {
        $tags = $this->toTagsArray($tags);

        if(!empty($tags)){
            $criteria = $this->getFindByTagsCriteria($tags);
            $this->getOwner()->getDbCriteria()->mergeWith($criteria);
        }

        return $this->getOwner();
    }
    /**
     * Alias of {@link taggedWith()}.
     * @param string|array $tags
     * @return CActiveRecord
     */
    public function withTags($tags) {
        return $this->taggedWith($tags);
    }
    /**
     * Delete all present tag bindings.
     * @return void
     */
    protected function deleteTags() {
        $this->updateCount(-1);

        $conn = $this->getConnection();
        $conn->createCommand(
            sprintf(
                "DELETE
                 FROM " .Yii::app()->db->getSchema()->quoteTableName('%s') . "
                 WHERE %s = %d",
                $this->getTagBindingTableName(),
                $this->getModelTableFkName(),
                $this->getOwner()->primaryKey
            )
        )->execute();
    }
    /**
     * Creates a tag.
     * Method is for future inheritance.
     * @param string $tag tag name.
     * @return void
     */
    protected function createTag($tag) {

        $builder = $this->getConnection()->getCommandBuilder();

        $values = array(
            $this->tagTableName => $tag
        );
        if(is_array($this->insertValues)){
            $values = array_merge($this->insertValues, $values);
        }

        $builder->createInsertCommand($this->tagTable, $values)->execute();

    }
    /**
     * Updates counter information in database.
     * Used if {@link tagTableCount} is not null.
     * @param int $count incremental ("1") or decremental ("-1") value.
     * @return void
     */
    protected function updateCount($count) {
        if($this->tagTableCount !== null){
            $conn = $this->getConnection();
            $conn->createCommand(
                sprintf(
                    "UPDATE %s
                    SET %s = %s + %s
                    WHERE %s in (SELECT %s FROM %s WHERE %s = %d)",
                    $this->tagTable,
                    $this->tagTableCount,
                    $this->tagTableCount,
                    $count,
                    $this->tagTablePk,
                    $this->tagBindingTableTagId,
                    $this->getTagBindingTableName(),
                    $this->getModelTableFkName(),
                    $this->getOwner()->primaryKey
                )
            )->execute();
        }
    }
}