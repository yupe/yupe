<?php
namespace application\modules\update\components;

use Yii;
use CException;
use CApplicationComponent;
use GuzzleHttp\Client;

class UpdateManager extends CApplicationComponent
{
    const DEFAULT_VERSION_LABEL = '---';

    const LOG_CATEGORY = 'update-center';

    protected  $checkUpdateUrl = 'http://update.yupe.ru/update/check';

    // 8 часов
    public $cacheTime = 43200;

    protected $client;

    public function init()
    {
        parent::init();

        if(!$this->checkUpdateUrl) {
            throw new CException("Unknown checkUpdateUrl...");
        }

        $this->client = new Client;
    }

    public function getModulesUpdateInfo()
    {
        try
        {
            $data = Yii::app()->getCache()->get('yupe::update::info');

            if(false === $data) {

                $data = $this->client->get($this->checkUpdateUrl)->json();

                Yii::app()->getCache()->set('yupe::update::info', $data, $this->cacheTime);
            }

            return $data;
        }
        catch(\Exception $e)
        {
            Yii::log($e->__toString(), \CLogger::LEVEL_ERROR, self::LOG_CATEGORY);

            return false;
        }
    }

    public function getModulesUpdateList(array $modules)
    {
        $data = Yii::app()->getCache()->get('yupe::update::list');

        if(false !== $data) {

            return $data;
        }

        $updates = $this->getModulesUpdateInfo();

        $data = ['total' => 0, 'modules' => [],'result' => !empty($updates)];

        foreach($modules['modules'] as $id => $module) {

            $version = isset($updates[$module->getId()]['version']) ? $updates[$module->getId()]['version'] : self::DEFAULT_VERSION_LABEL;

            $update = false;

            if($version != self::DEFAULT_VERSION_LABEL && $version != $module->getVersion()) {
                $data['total']++;
                $update = true;
            }

            $data['modules'][$module->getId()] = [
                'id'      => $id,
                'module'  => $module,
                'version' => $version,
                'update'  => $update,
                'change'  => $update ? $updates[$module->getId()]['change'] : ''
            ];
        }

        Yii::app()->getCache()->set('yupe::update::list', $data, $this->cacheTime);

        return $data;
    }

    public function getUpdatesCount()
    {
        $data = Yii::app()->getCache()->get('yupe::update::list');

        if(false === $data) {
            return false;
        }

        return isset($data['total']) ? $data['total'] : 0;
    }

} 
