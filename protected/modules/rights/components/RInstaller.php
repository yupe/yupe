<?php
/**
* Rights installer component class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.3
*/
class RInstaller extends CApplicationComponent
{
    const ERROR_NONE=0;
    const ERROR_QUERY_FAILED=1;

	/**
	* @property array the roles assigned to users implicitly.
	*/
	public $defaultRoles;
	/**
	* @property string the name of the superuser role.
	*/
	public $superuserName;
	/**
	* @property string the name of the authenticated role.
	*/
	public $authenticatedName;
	/**
	* @property string the name of the guest role.
	*/
	public $guestName;
    /**
     * @property RAuthManager the authorization manager.
     */
	private $_authManager;
    /**
     * @property boolean whether Rights is installed.
     */
	private $_installed;

	/**
	* @property CDbConnection
	*/
	public $db;

	/**
	* Initializes the installer.
	* @throws CException if the authorization manager or the web user
	* is not configured to use the correct class.
	*/
	public function init()
	{
		parent::init();

		// Make sure the application is configured
		// to use a valid authorization manager.
		$authManager = Yii::app()->getAuthManager();
		if( ($authManager instanceof RDbAuthManager)===false )
			throw new CException(Rights::t('install', 'Application authorization manager must extend the RDbAuthManager class.'));

		// Make sure the application is configured
		// to use a valid web user.
		$user = Yii::app()->getUser();
		if( ($user instanceof RWebUser)===false )
			throw new CException(Rights::t('install', 'Application web user must extend the RWebUser class.'));

		$this->_authManager = $authManager;
		$this->db = $this->_authManager->db;
	}

	/**
	* Runs the installer.
	* @param boolean whether to drop tables if they exists.
	* @return boolean whether the installer ran successfully.
	*/
	public function run()
	{
        // Get the table names.
        $itemTable = $this->_authManager->itemTable;
        $itemChildTable = $this->_authManager->itemChildTable;
        $assignmentTable = $this->_authManager->assignmentTable;
        $rightsTable = $this->_authManager->rightsTable;

        // Fetch the schema.
        $schema = file_get_contents(dirname(__FILE__).'/../data/schema.sql');

        // Correct the table names.
        $schema = strtr($schema, array(
            'AuthItem'=>$itemTable,
            'AuthItemChild'=>$itemChildTable,
            'AuthAssignment'=>$assignmentTable,
            'Rights'=>$rightsTable,
        ));

        // Convert the schema into an array of sql queries.
        $schema = preg_split("/;\s*/", trim($schema, ';'));

        // Start transaction
        $txn = $this->db->beginTransaction();

        try
        {
            // Execute each query in the schema.
            foreach( $schema as $sql )
            {
                $command = $this->db->createCommand($sql);
                $command->execute();
            }

            // Insert the necessary roles.
            $roles = $this->getUniqueRoles();
            foreach( $roles as $roleName )
            {
                $sql = "INSERT INTO {$itemTable} (name, type, data)
                    VALUES (:name, :type, :data)";
                $command = $this->db->createCommand($sql);
                $command->bindValue(':name', $roleName);
                $command->bindValue(':type', CAuthItem::TYPE_ROLE);
                $command->bindValue(':data', 'N;');
                $command->execute();
            }

            // Assign the logged in user the superusers role.
            $sql = "INSERT INTO {$assignmentTable} (itemname, userid, data)
                VALUES (:itemname, :userid, :data)";
            $command = $this->db->createCommand($sql);
            $command->bindValue(':itemname', $this->superuserName);
            $command->bindValue(':userid', Yii::app()->getUser()->id);
            $command->bindValue(':data', 'N;');
            $command->execute();

            // All commands executed successfully, commit.
            $txn->commit();
            return self::ERROR_NONE;
        }
        catch( CDbException $e )
        {
            // Something went wrong, rollback.
            $txn->rollback();

            return self::ERROR_QUERY_FAILED;
        }
	}

	/**
	* Returns a list of unique roles names.
	* @return array the list of roles.
	*/
	private function getUniqueRoles()
	{
		$roles = CMap::mergeArray($this->defaultRoles, array(
            $this->superuserName,
            $this->authenticatedName,
            $this->guestName,
        ));
		return array_unique($roles);
	}

	/**
	* @return boolean whether Rights is installed.
	*/
	public function getInstalled()
	{
		if( $this->_installed!==null )
		{
			return $this->_installed;
		}
		else
		{
            $schema = array(
                "SELECT COUNT(*) FROM {$this->_authManager->itemTable}",
                "SELECT COUNT(*) FROM {$this->_authManager->itemChildTable}",
                "SELECT COUNT(*) FROM {$this->_authManager->assignmentTable}",
                "SELECT COUNT(*) FROM {$this->_authManager->rightsTable}",
            );

			try
			{
                foreach( $schema as $sql )
                {
                    $command = $this->db->createCommand($sql);
                    $command->queryScalar();
                }

				$installed = true;
			}
			catch( CDbException $e )
			{
				$installed = false;
			}

			return $this->_installed = $installed;
		}
	}
}
