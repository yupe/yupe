<?php

/**
 * @class DGSphinxSearchResult
 * @ingroup DGSearchExtension
 * @brief represent full search system results
 *
 * "A" - Team:
 * @author     Andrey Evsyukov <thaheless@gmail.com>
 * @author     Alexey Spiridonov <a.spiridonov@2gis.ru>
 * @author     Alexey Papulovskiy <a.papulovskiyv@2gis.ru>
 * @author     Alexander Biryukov <a.biryukov@2gis.ru>
 * @author     Alexander Radionov <alex.radionov@gmail.com>
 * @author     Andrey Trofimenko <a.trofimenko@2gis.ru>
 * @author     Artem Kudzev <a.kiudzev@2gis.ru>
 *
 * @link       http://www.2gis.ru
 * @copyright  2GIS
 * @license http://www.yiiframework.com/license/
 *
 * Requirements:
 * --------------
 *  - Yii 1.1.x or above
 *  - SphinxClient php library
 */

class DGSphinxSearchResult
{

    /**
     * @var boolean
     * @brief enable Yii profiling
     */
    public $enableProfiling = false;
    /**
     * @var boolean
     * @brief enable Yii tracing
     */
    public $enableResultTrace = false;
    /**
     * @var array
     * @brief data strore
     */
    private $data = array();
    /**
     * @var object
     * @brief search criteria store
     */
    private $criteria;

    /**
     * @brief DGSphinxSearchResult constructor
     * @param array $data
     * @param objecy $criteria
     */
    public function __construct(array $data, $criteria)
    {
        if ($this->enableProfiling) {
            Yii::beginProfile("Init DGSphinxSearchResult", 'CEXT.DGSearch.DGSphinxSearchResult.init');
        }

        $this->criteria = $criteria;

        $ar = array();

        foreach ($data['matches'] as $id => $data) {
            $resData = new stdClass();
            foreach ($data['attrs'] as $key => $value) {
                $resData->$key = $value;
            }
            $resData->id = $id;

            //if(YII_DEBUG) {
                $resData->_weight = $data['weight'];
            //}

            $ar[$id] = $resData;
        }

        $this->setIdList($ar);

        if ($this->enableProfiling) {
            Yii::endProfile("Init DGSphinxSearchResult", 'CEXT.DGSearch.DGSphinxSearchResult.init');
        }
    }

    /*
     * @brief get values from data from param
     * @return array
     */

    private function getIdListByParam(array $list, $param, $isReturnEmpty = true)
    {
        $ret = array();
        foreach ($list as $id => $item) {
            if (isset($item->$param)) {
                if ($isReturnEmpty || $item->$param) {
                    $ret[$id] = $item->$param;
                }
            }
        }
        return array_keys(array_flip($ret));
    }

    /*
     * @brief get page from data
     * @return array
     */

    private function getPageFromData(array $list)
    {
        if (isset($this->getCriteria()->paginator)) {
            $pageSize = $this->getCriteria()->paginator->getPageSize();
            $offset = $this->getCriteria()->paginator->getOffset();
        } else {
            $pageSize = count($list);
            $offset = 0;
        }
        return array_slice($list, $offset, $pageSize, true);
    }

    /*
     * @brief set  id's  and set  total count
     * @return array
     */

    public function setIdList($list)
    {
        $this->data = $list;
        if (isset($this->getCriteria()->paginator)) {
            $this->getCriteria()->paginator->setItemCount(count($list));
        };
    }

    /*
     * @brief return all id's in search result
     * @return array
     */

    public function getIdList()
    {
        return array_keys($this->data);
    }

    /*
     * @brief return page id's in search result by paginator
     * @return array
     */

    public function getIdPage()
    {
        return array_keys($this->getPageFromData($this->data));
    }

    /*
     * @brief return all geo id's in search result
     * @return array
     */

    public function getParamIdList($param, $isReturnEmpty = true)
    {
        return $this->getIdListByParam($this->data, $param, $isReturnEmpty);
    }

    /*
     * @brief return all geo id's in search result
     * @return array
     */

    public function getParamIdPage($param)
    {
        return $this->getIdListByParam($this->getPageFromData($this->data), $param);
    }

    /**
     * @brief return merged result data
     * @param ids   array of ids  array(1,2,3,4,65,74,342)
     * @return array
     */
    public function filterByParamIds($param, array $ids)
    {
        if ($this->enableResultTrace) {
            Yii::trace('Filtered by ' . $param . ' with values: ' . TraceTextHelper::printData($ids), 'CEXT.DGSearch.Result.filterByParamIds');
        }
        if (count($ids) == 0) {
            $this->setIdList(array());
            return false;
        }
        $ret = array();
        foreach ($this->data as $id => $item) {
            if (isset($item->$param)) {
                if (in_array($item->$param, $ids)) {
                    $ret[$id] = $item;
                }
            }
        }
        $this->setIdList($ret);
    }

    /**
     * @brief return total rescived from full search engine results count
     * @return int
     */
    public function getTotal()
    {
        return count($this->data);
    }

    /**
     * @brief return search criteria
     * @return CSearchCriteria object
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @brief return paginator
     * @return CPaginator object
     */
    public function getPaginator()
    {
	$criteria = $this->getCriteria();
	if(isset($criteria->paginator))
	    return $criteria->paginator;
    }

    /**
     * @brief return data array
     * @return array
     */
    public function getRawData()
    {
        return $this->data;
    }

    /**
     * @brief data array as data
     * @return array
     */
    public function setRawData(array $data)
    {
        return $this->data = $data;
    }

    /**
     * @brief text casting object
     * @details return ids for cur page in format '1,2,3,..'
     * @return string
     */
    public function __toString()
    {
        //TODO  delete this method
        return join(',', $this->getIdPage());
    }

}