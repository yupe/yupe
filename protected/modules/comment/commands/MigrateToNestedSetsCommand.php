<?php
/**
 * Converter for migrating existing comments
 * from Adjacency List to Nested Sets.
 *
 * @category YupeConsoleCommand
 * @package  yupe.commands
 * @author   YupeTeam <team@yupe.ru>
 * @author   Anton Kucherov <idexter.ru@gmail.com>
 * @link     http://yupe.ru
 */
use yupe\components\Migrator;

class MigrateToNestedSetsCommand extends CConsoleCommand
{
    const NS_MIGRATION_NAME = 'm130704_095200_comment_nestedsets';
    const LOCK_FILE_NAME = 'MigrateToNestedSetsCommand.lock~';

    public $migrator;
    public $db;

    public function init()
    {
        parent::init();
        Yii::import('application.modules.yupe.components.*');
        Yii::import('application.modules.yupe.models.*');
        Yii::import('application.modules.comment.models.*');

        $this->migrator = (is_object($this->migrator)) ? $this->migrator : new Migrator();
        $this->db = (is_object($this->db)) ? $this->db : Yii::app()->db;
    }

    /**
     * Main Adjacency List to Nested Sets Converter Action
     */
    public function actionIndex()
    {
        if (!$this->converterLocked()) {
            if ($this->NsMigrationExists($this->migrator)) {
                echo "Checking for '" . self::NS_MIGRATION_NAME . "' migration -> [OK]\n";
            } else {
                $this->migrationUp();
            }
            $this->createRootElementsForOldComments();
            $this->buildNestedSetsTree();

            $this->lockConverter();
        } else {
            echo "Converter is LOCKED.\n";
            echo "1. Use './yiic migratetonestedsets unlock' to unlock converter and migrateDown.\n";
            echo "2. Restore you 'yupe_comments_comments' dump;\n";
            echo "3. After in you can try './yiic migratetonestedsets' to convert again.\n";
        }
    }

    public function actionUnlock()
    {
        if (file_exists(dirname(__FILE__) . '/' . self::LOCK_FILE_NAME)) {
            if ($this->NsMigrationExists($this->migrator)) {
                $this->migrator->migrateDown('comment', self::NS_MIGRATION_NAME);
            }

            unlink(dirname(__FILE__) . '/' . self::LOCK_FILE_NAME);
        }
    }

    /**
     * Check, if NestedSets Migration exists in DB.
     * @param  Migrator $migrator
     * @return bool
     */
    public function NsMigrationExists(Migrator $migrator)
    {
        $history = $migrator->getMigrationHistory('comment');
        if (array_key_exists(self::NS_MIGRATION_NAME, $history)) {
            return true;
        }

        return false;
    }

    /**
     * Confirm NestedSets Migration
     * @return bool Migrate Status
     */
    public function migrationUp()
    {
        echo "Prepare for migrating to '" . self::NS_MIGRATION_NAME . "'...\n";
        if ($this->migrator->updateToLatest('comment')) {
            echo "Migrating to '" . self::NS_MIGRATION_NAME . "' migration -> [OK]\n";

            return true;
        } else {
            echo "Migrating to '" . self::NS_MIGRATION_NAME . "' migration -> [FAILED]\n";

            return false;
        }
    }

    protected function createRootElementsForOldComments()
    {
        $db = $this->db;

        // Выбираем модели у которых есть комментарии.
        $oldRoots = $db->createCommand()
            ->select('id,model,model_id,user_id')
            ->from("{{comment_comment}}")
            ->where("parent_id is null")
            ->group("CONCAT(model,model_id)")
            ->queryAll();

        // Создаем по одному корню для каждой сущности у которой есть комментарии
        if (!empty($oldRoots)) {
            echo "Selecting models which contains comments -> [OK]\n";
            foreach ($oldRoots as &$root) {
                $insert = [
                    "model"         => $root["model"],
                    "model_id"      => $root["model_id"],
                    "status"        => Comment::STATUS_APPROVED,
                    "user_id"       => $root["user_id"],
                    "name"          => "",
                    "url"           => "",
                    "email"         => "",
                    "text"          => "root",
                    "ip"            => "",
                    "create_time" => "1970-01-01 00:00:00"
                ];
                $db->createCommand()->insert("{{comment_comment}}", $insert);
            }
        } else {
            echo "Selecting models which contains comments -> [NO COMMENTS]\n";
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
        $rootParents = [];
        if (!empty($newRoots)) {
            foreach ($newRoots as &$newroot) {
                $rootParents[$newroot["model"] . $newroot["model_id"]] = $newroot["id"];
            }
        }

        // Выбираем коренные коммментарии
        $roots = $db->createCommand()
            ->select('id,model,model_id,user_id')
            ->from("{{comment_comment}}")
            ->where("parent_id is null AND text<>'root'")
            ->queryAll();

        // Помещаем старые коренные комментарии внутрь корней
        foreach ($roots as &$root) {
            $db->createCommand()->update(
                '{{comment_comment}}',
                ['parent_id' => $rootParents[$root["model"] . $root["model_id"]]],
                "id='{$root["id"]}'"
            );
        }

        // Убираем лишний текст из коренных элементов деревьев.
        $db->createCommand()->update('{{comment_comment}}', ['text' => ""], "text='root'");
    }

    protected function buildNestedSetsTree()
    {
        $db = $this->db;

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
        foreach ($roots as &$root) {
            $comment = new \Comment();
            $comment->setAttributes($root, false);
            $comment->saveNode(false);
        }

        // Добавляем в таблицу все остальные элементы
        foreach ($others as &$other) {
            $rootNode = \Comment::model()->findByPk($other["parent_id"]);
            if ($rootNode != null) {
                $comment = new \Comment();
                $comment->setAttributes($other, false);
                $comment->appendTo($rootNode, false);
            } else {
                echo 'Bad comment which parent was deleted: ' . $other["id"] . "\n";
            }
        }
        echo "Converted succesfully.\n";
    }

    public function lockConverter()
    {
        file_put_contents(dirname(__FILE__) . '/' . self::LOCK_FILE_NAME, ' ');
    }

    public function converterLocked()
    {
        if (file_exists(dirname(__FILE__) . '/' . self::LOCK_FILE_NAME)) {
            return true;
        }
        return false;
    }
}
