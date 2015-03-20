<?php

/**
 * DbUrlManager extension.
 * EDbUrlManager class file.
 * Provides dynamic URL rules based on database contents.
 * Dual-licensed: Yii Framework License or MIT License.
 *
 * This version is tested with Yii Framework 1.1.3.
 *
 * @author Rodrigo Coelho <ext.dev@contas.rodrigocoelho.com.br>
 * @copyright Copyright &copy; 2010 Rodrigo Coelho
 * @license http://www.yiiframework.com/license/ Yii Framework License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package ext.DbUrlManager
 * @version 1.0
 */
/**
 * TODO: I18N
 * TODO: Caching
 * TODO: Test the queries with multiple RDBMSs.
 *
 * Known issues:
 *
 * It is still possible to get to the controller/action without valid parameters.
 * This can happen when the request route is the controller/action directly.
 * The action should always validate the parameters.
 *
 * EDbUrlRule::parseUrl is a copy of Yii framework's CUrlRule::parseUrl
 * with a few new lines of code. This method may lag behind the framework's
 * enhancements. You're advised to check for updates on this extension or update
 * the code by yourself upon framework updates.
 */

/**
 * EDbUrlManager provides dynamic database-based URL rules.
 *
 * These dynamic rules are like Wordpress' "pretty permalinks" or "friendly URLs".
 * You do not have to have the controller name (or ID) on the URL: this extension
 * can handle the request URI and route it to the correct controller.
 *
 * Installation: place the extension directory "DbUrlManager" under
 * the directory protected/extensions in your application.
 * Follow the instructions below to configure your application to use the extension.
 *
 * You should use EDbUrlManager with 'format'=>'path' or it will not work.
 *
 * Setup the extension like this on your configuration file:
 * <pre>
 * 'urlManager'=>array(
 *     'class'=>'ext.DbUrlManager.EDbUrlManager',
 *     'urlFormat'=>'path',
 *     'connectionID'=>'db',
 *     ...
 * </pre>
 *
 * The properties in the example above:
 * <ul>
 * <li>class: specifies the extension class.</li>
 * <li>urlFormat: this extension must be used with urlFormat set to 'path'.</li>
 * <li>connectionID: the ID of CDbConnection application component.</li>
 * </ul>
 *
 * The dynamic rules must be specified using the array format, like the example below:
 * <pre>
 * 'rules'=>array(
 *     // A dynamic rule.
 *     '<author:\w+>/<post:\w+>'=>array(
 *         'post/view',
 *         'type'=>'db',
 *         'fields'=>array(
 *             'author'=>array(
 *                 'table'=>'tbl_author',
 *                 'field'=>'author_name'
 *             ),
 *             'post'=>array(
 *                 'table'=>'tbl_post',
 *                 'field'=>'post_slug'
 *             ),
 *         ),
 *     ),
 *     // Now additional standard rules.
 *     '<controller:\w+>/<id:\d+>'=>'<controller>/view',
 *     '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
 *     '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
 * ),
 * </pre>
 *
 * You can have as many 'db' rules as you wish, in any position of the 'rules' array.
 * Notice that the position determines the rule priority. If the 'db' rule of the
 * example was below of the third standard rule, it would be never reached because
 * the regex patterns are the same.
 *
 * The rule named parameters (in the example above 'author' and 'post') are linked
 * to a table and a field via the 'fields' property.
 *
 * The new rule properties are:
 * <ul>
 * <li>type: specifies the type of the rule. Use 'db' for dynamic rules. Standard
 * rules doesn't need this property to be set.</li>
 * <li>fields: the table and the field related to the rule parameter.</li>
 * </ul>
 *
 * How it works (using the rule of the example above): in a request URI like
 * "john/my-first-post", the extension will check if there is a user called
 * "john" and a post slug "my-first-post". If there are, the route used
 * will be the one specified in the rule: post/view.
 * If not, it will ignore the current rule and try to match the next one.
 *
 * The dynamic rules can also be used for creating URLs, just like a
 * standard rule. It is transparent and does not need any setup, just call:
 * <pre>
 * Yii::app()->createUrl('post/view',array('author'=>'john','post'=>'my-first-post'));
 * </pre>
 * This is similar to and works with CHtml::link.
 * Notice that the values specified for the parameters are not checked on the database.
 *
 * EDbUrlManager may be accessed via {@link CWebApplication::getUrlManager()}.
 *
 * Performance tips:
 * <ul>
 * <li>Each parameter on each dynamic rule means one database query. Do not specify
 * more parameters than the needed to identify the controller.</li>
 * <li>You can specify standard rules above the dynamic rules. You can specify the
 * name (ID) of the controller in the standard rule instead of a regex pattern if
 * the regex patterns of the rules would be the same. This avoids unecessary queries.</li>
 * <li>Remember to use an index on the database fields used in dynamic rules.</li>
 * </ul>
 *
 * @author Rodrigo Coelho <ext.dev@contas.rodrigocoelho.com.br>
 * @copyright Copyright &copy; 2010 Rodrigo Coelho
 * @license http://www.yiiframework.com/license/ Yii Framework License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package ext.DbUrlManager
 */

namespace yupe\components\urlManager;

use CUrlManager;
use Yii;
use CDbConnection;
use CDbException;
use CException;
use CUrlRule;
use PDO;

class EDbUrlManager extends CUrlManager
{

    /**
     * @var string the ID of CDbConnection application component.
     * Defaults to 'db' which refers to the primary database application component.
     * @since 1.0
     */
    public $connectionID = 'db';
    /**
     * @var CDbConnection the DB connection instance.
     * @since 1.0
     */
    private $_db;

    /**
     * @return CDbConnection the DB connection instance
     * @throws CException if {@link connectionID} does not point to a valid application component.
     * @since 1.0
     */
    public function getDbConnection()
    {
        if ($this->_db !== null) {
            return $this->_db;
        } else {
            if (($id = $this->connectionID) !== null) {
                if (($this->_db = Yii::app()->getComponent($id)) instanceof CDbConnection) {
                    return $this->_db;
                }
            }
        }
        throw new CException(
            Yii::t(
                'DbUrlManager',
                'EDbUrlManager.connectionID "{id}" does not point to a valid CDbConnection application component.',
                array('{id}' => $id)
            )
        );
    }

    /**
     * Overrides {@link CUrlManager::createUrlRule}
     * Creates a URL rule (EDbUrlRule) instance.
     * @param string the pattern part of the rule
     * @param mixed the route part of the rule. This could be a string or an array
     * @return EDbUrlRule the URL rule instance
     * @since 1.0
     */
    protected function createUrlRule($route, $pattern)
    {
        return new EDbUrlRule($route, $pattern);
    }

}

/**
 * EDbUrlRule class.
 * Provides support for dynamic URL rules.
 *
 * @author Rodrigo Coelho <ext.dev@contas.rodrigocoelho.com.br>
 * @copyright Copyright &copy; 2010 Rodrigo Coelho
 * @license http://www.yiiframework.com/license/ Yii Framework License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package ext.DbUrlManager
 */
class EDbUrlRule extends CUrlRule
{

    /**
     * @var string the type of the URL rule.
     * Legal values are: null; 'db': dynamic db-based URL rule.
     * @since 1.0
     */
    public $type;
    /**
     * @var array the mapping from route param name to table and field names, e.g. 'paramName'=>array('tableName'=>'fieldName')
     * @since 1.0
     */
    public $fields = array();

    /**
     * Overrides {@link CUrlRule::__construct}
     * Constructor. Stores the rules' new properties, then call the parent constructor.
     * @since 1.0
     */
    public function __construct($route, $pattern)
    {
        if (is_array($route)) {
            if (isset($route['type'])) {
                $this->type = $route['type'];
            }
            if (isset($route['fields'])) {
                $this->fields = $route['fields'];
            }
        }
        parent::__construct($route, $pattern);
    }

    /**
     * Parases a URL based on this rule.
     * This is an exact copy of Yii framework's 1.1.3 CUrlRule::parseUrl with
     * a call to EDbUrlRule::handleParseMatch.
     * @param CUrlManager the URL manager
     * @param CHttpRequest the request object
     * @param string path info part of the URL
     * @param string path info that contains the potential URL suffix
     * @return string the route that consists of the controller ID and action ID
     * @see handleParseMatch
     */
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if ($manager->caseSensitive && $this->caseSensitive === null || $this->caseSensitive) {
            $case = '';
        } else {
            $case = 'i';
        }

        if ($this->urlSuffix !== null) {
            $pathInfo = $manager->removeUrlSuffix($rawPathInfo, $this->urlSuffix);
        }

        // URL suffix required, but not found in the requested URL
        if ($manager->useStrictParsing && $pathInfo === $rawPathInfo) {
            $urlSuffix = $this->urlSuffix === null ? $manager->urlSuffix : $this->urlSuffix;
            if ($urlSuffix != '' && $urlSuffix !== '/') {
                return false;
            }
        }

        if ($this->hasHostInfo) {
            $pathInfo = $request->getHostInfo() . rtrim('/' . $pathInfo, '/');
        }

        $pathInfo .= '/';

        if (preg_match($this->pattern . $case, $pathInfo, $matches)) {
            // Calls EDbUrlRule::handleParseMatch.
            // If it returns false, the match should be ignored.
            if (!$this->handleParseMatch($manager, $matches)) {
                return false;
            }

            foreach ($this->defaultParams as $name => $value) {
                if (!isset($_GET[$name])) {
                    $_REQUEST[$name] = $_GET[$name] = $value;
                }
            }
            $tr = array();
            foreach ($matches as $key => $value) {
                if (isset($this->references[$key])) {
                    $tr[$this->references[$key]] = $value;
                } else {
                    if (isset($this->params[$key])) {
                        $_REQUEST[$key] = $_GET[$key] = $value;
                    }
                }
            }
            if ($pathInfo !== $matches[0]) // there're additional GET params
            {
                $manager->parsePathInfo(ltrim(substr($pathInfo, strlen($matches[0])), '/'));
            }
            if ($this->routePattern !== null) {
                return strtr($this->route, $tr);
            } else {
                return $this->route;
            }
        } else {
            return false;
        }
    }

    /**
     * This method is invoked upon a rule match by {@link EDbUrlRule::parseUrl}.
     * If the rule type is 'db', {@link EDbUrlRule::checkDbRule} is called.
     * @param CUrlManager the URL manager
     * @param array the regex matches as found by {@link CUrlRule::parseUrl}
     * @return boolean whether the matched rule should be used.
     * @since 1.0
     */
    protected function handleParseMatch($manager, $matches)
    {
        if ($this->type !== 'db') {
            return true;
        }

        foreach ($matches as $key => $value) {
            if (isset($this->fields[$key])) {
                $this->fields[$key]['value'] = $value;
            }
        }
        return $this->checkDbRule($manager);
    }

    /**
     * Checks the URL rule against the path info from the current request.
     * @return boolean whether the URL matches the data in the database.
     * @since 1.0
     */
    protected function checkDbRule($manager)
    {
        foreach ($this->fields as $param => $data) {
            $cacheName = 'edb_' . $data['table'] . $data['field'] . $data['value'];

            $value = Yii::app()->cache->get($cacheName);
            if ($value === false) {
                $sql = "SELECT {$data['field']} FROM {$data['table']} WHERE {$data['field']}=:value LIMIT 1";
                $command = $manager->getDbConnection()->createCommand($sql);
                $command->bindValue(':value', $data['value'], PDO::PARAM_STR);

                $value = ($command->queryScalar() !== false);
                Yii::app()->cache->set($cacheName, (int)$value, 60 * 60 * 24);
            }

            if ((bool)$value === false) {
                return false;
            }
        }
        return true;
    }

}