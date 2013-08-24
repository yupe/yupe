<?php
/**
* Converter for migrating existing comments
* from Adjacency List to Nested Sets.
*
* @category YupeConsoleCommand
* @package  YupeCMS
* @author   YupeTeam <team@yupe.ru>
* @author   Anton Kucherov <idexter.ru@gmail.com>
* @link     http://yupe.ru
*/
class YMigrateToNestedSetsCommand extends CConsoleCommand
{
    const NS_MIGRATION_NAME = 'm130704_095200_comment_nestedsets';

    public function init()
    {
        parent::init();
        Yii::import('application.modules.yupe.components.*');
        Yii::import('application.modules.yupe.models.*');
        Yii::import('application.modules.comment.models.*');
    }

    public function actionIndex()
    {
        $this->_checkForNestedSetsMigration();
        $this->_checkForNestedSetsBehaviorExists();
        $this->_createRootElementsForOldComments();
        $this->_buildNestedSetsTree();
    }

    private function _checkForNestedSetsBehaviorExists()
    {
        $commentsConfigFile = Yii::getPathOfAlias("application.config.modules").'/comment.php';
        if(!file_exists($commentsConfigFile))
        {
            echo "ERROR: Comments config file '{$commentsConfigFile}' not found. Try to install Comments module first.\n";
            Yii::app()->end();
        }
        $commentsConfigArray = include_once($commentsConfigFile);

        $comment = new Comment;
        $behaviors = $comment->behaviors();
        if(!array_key_exists("NestedSetBehavior",$behaviors))
        {
            echo "ERROR: Behavior 'NestedSetBehavior' doesn't exist in Comments model\n";
            Yii::app()->end();
        }

        if(!is_array($commentsConfigArray) ||
           !array_key_exists("import",$commentsConfigArray) ||
           !is_array($commentsConfigArray["import"]) ||
           !in_array($behaviors["NestedSetBehavior"]["class"],$commentsConfigArray["import"]))
        {
            echo "ERROR: Path to 'NestedSetBehavior' ({$behaviors["NestedSetBehavior"]["class"]}) doesn't set in 'import' section in comments config file ({$commentsConfigFile}).\n";
            Yii::app()->end();
        }

        echo "SUCCESS: Checking that the NestingSetBehavior is exists and configs is valid.\n";
    }

    private function _checkForNestedSetsMigration()
    {
        $migrator = new Migrator();
        $history = $migrator->getMigrationHistory('comment');
        if(array_key_exists(self::NS_MIGRATION_NAME,$history))
        {
            echo "SUCCESS: Checking for '".self::NS_MIGRATION_NAME."' migration.\n";
        }else{
            echo "Preparing for migrating to '".self::NS_MIGRATION_NAME."'...\n";
            if($migrator->updateToLatest('comment'))
            {
                echo "SUCCESS: Migrating to '".self::NS_MIGRATION_NAME."' migration.\n";
            }else{
                echo "FAILED: Migrating to '".self::NS_MIGRATION_NAME."' migration.\n";
                Yii::app()->end();
            }
        }
    }

    private function _createRootElementsForOldComments()
    {
        $db = Yii::app()->db;

        // Выбираем модели у которых есть комментарии.
        $oldRoots = $db->createCommand()
            ->select('id,model,model_id,user_id')
            ->from("{{comment_comment}}")
            ->where("parent_id is null")
            ->group("CONCAT(model,model_id)")
            ->queryAll();

        // Создаем по одному корню для каждой сущности у которой есть комментарии
        if(!empty($oldRoots))
        {
            echo "SUCCESS: Selecting models which contains comments.\n";
            foreach($oldRoots as &$root)
            {
                $insert = array(
                    "model"=>$root["model"],
                    "model_id"=>$root["model_id"],
                    "status"=>Comment::STATUS_APPROVED,
                    "user_id"=>$root["user_id"],
                    "name"=>"",
                    "url"=>"",
                    "email"=>"",
                    "text"=>"root",
                    "ip"=>'127.0.0.1',
                    "creation_date"=>date('Y-m-d H:i:s')
                );
                $db->createCommand()->insert("{{comment_comment}}",$insert);
            }
        }else{
            echo "SUCCESS: There is on comments in comments table.\n";
            echo "Converted succesfully.\n";
            Yii::app()->end();
        }

        // Получаем только что созданные корни
        $newRoots = $db->createCommand()
            ->select('id,model,model_id')
            ->from("{{comment_comment}}")
            ->where("parent_id is null AND text='root'")
            ->queryAll();

        // Генерируем массив идентификаторов корней деревьев комментариев.
        $rootParents = array();
        if(!empty($newRoots))
            foreach($newRoots as &$newroot)
                $rootParents[$newroot["model"].$newroot["model_id"]] = $newroot["id"];

        // Выбираем коренные коммментарии
        $roots = $db->createCommand()
            ->select('id,model,model_id,user_id')
            ->from("{{comment_comment}}")
            ->where("parent_id is null AND text<>'root'")
            ->queryAll();

        // Помещаем старые коренные комментарии внутрь корней
        foreach($roots as &$root)
        {
            $db->createCommand()->update('{{comment_comment}}',
                array('parent_id'=>$rootParents[$root["model"].$root["model_id"]]),"id='{$root["id"]}'");
        }

        // Убираем лишний текст из коренных элементов деревьев.
        $db->createCommand()->update('{{comment_comment}}',array('text'=>""),"text='root'");
    }

    private function _buildNestedSetsTree()
    {
        $db = Yii::app()->db;

        // Получаем все коренные элементы на основе значения parent_id
        $roots = $db->createCommand()
            ->select('*')
            ->from("{{comment_comment}}")
            ->where("parent_id is null")
            ->queryAll();

        // Получаем все остальные элементы (не являющиеся корнем)
        $others = $db->createCommand()
            ->select('*')
            ->from("{{comment_comment}}")
            ->where("parent_id is not null")
            ->queryAll();

        // Очищаем таблицу комментариев
        $db->createCommand()->truncateTable("{{comment_comment}}");

        // Добавляем в таблицу коренные элементы
        foreach($roots as &$root)
        {
            $comment = new Comment();
            $comment->setAttributes($root,false);
            $comment->saveNode(false);
        }

        // Добавляем в таблицу все остальные элементы
        foreach($others as &$other)
        {
            $rootNode=Comment::model()->findByPk($other["parent_id"]);

            $comment = new Comment();
            $comment->setAttributes($other,false);
            $comment->appendTo($rootNode,false);
        }
        echo "Converted succesfully.\n";
    }
}