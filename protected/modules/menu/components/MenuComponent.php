<?php

/**
 * Class MenuComponent
 */
class MenuComponent extends CApplicationComponent
{
    /**
     * @var array
     */
    public $modules;

    /**
     * @return array
     */
    public function getModuleList()
    {
        $data = [];

        if ($this->modules) {
            foreach ($this->modules as $moduleName => $module) {
                if (Yii::app()->hasModule($moduleName)) {
                    $data[$moduleName] = Yii::app()->getModule($moduleName)->getName();
                }
            }
        }

        return $data;
    }

    /**
     * @param string $moduleName
     * @return array
     */
    public function getEntityList($moduleName)
    {
        $data = [];

        if ($entities = $this->getEntitiesByModuleName($moduleName)) {
            foreach ($entities as $entityName => $entity) {
                $data[$entityName] = $entity['label'];
            }
        }

        return $data;
    }

    /**
     * @param string $moduleName
     * @param string $entityName
     * @return array
     * @throws CException
     */
    public function getEntityItemList($moduleName, $entityName)
    {
        $data = [];

        if ($moduleName !== null && $entityName !== null) {
            $entity = $this->getEntity($moduleName, $entityName);
            $model = $this->getModel($entity['model']);

            /* @var $model \yupe\models\YModel */
            $items = $model::model()->findAll();

            if ($items) {
                $data = CHtml::listData($items, 'id', $entity['modelAttributeName']);
            }
        }

        return $data;
    }

    /**
     * @param string $moduleName
     * @param string $entityName
     * @param integer $entityId
     * @return string|null
     * @throws CException
     */
    public function getEntityItemUrl($moduleName, $entityName, $entityId)
    {
        $entity = $this->getEntity($moduleName, $entityName);
        $model = $this->getModel($entity['model']);
        $params = [];

        /* @var $model \yupe\models\YModel */
        $item = $model::model()->find('id = :id', [':id' => $entityId]);

        if (!$item) {
            return null;
        }

        if (isset($entity['url']['params'])) {
            foreach ($entity['url']['params'] as $param => $modelAttribute) {
                $params[$param] = $item->getAttribute($modelAttribute);
            }
        }

        return Yii::app()->createUrl($entity['url']['route'], $params);
    }

    /**
     * @param string $model
     * @return mixed
     * @throws CException
     */
    protected function getModel($model)
    {
        $modelClass = Yii::import($model);
        return new $modelClass();
    }

    /**
     * @param string $moduleId
     * @return array
     * @throws Exception
     */
    protected function getEntitiesByModuleName($moduleId)
    {
        if (empty($moduleId)) {
            throw new Exception(Yii::t('MenuModule.menu', 'Module ID not set'));
        }

        return $this->modules[$moduleId]['entities'];
    }

    /**
     * @param string $moduleId
     * @param string $entityName
     * @return array
     * @throws Exception
     */
    protected function getEntity($moduleId, $entityName)
    {
        try {
            return $this->getEntitiesByModuleName($moduleId)[$entityName];
        } catch (Exception $e) {
            throw $e;
        }
    }
}