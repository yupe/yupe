<?php
/**
 * YiiDebugToolbarPanelLogging class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanelLogging represents an ...
 *
 * Description of YiiDebugToolbarPanelLogging
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugToolbarPanelLogging extends YiiDebugToolbarPanel
{
    /**
     * Message count.
     *
     * @var integer
     */
    private $_countMessages;

    /**
     * Logs.
     *
     * @var array
     */
    private $_logs;

    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        return YiiDebug::t('Logging');
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSubTitle()
    {
        return YiiDebug::t('{n} message|{n} messages', array($this->countMessages));
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return YiiDebug::t('Log Messages');
    }

    /**
     * Get logs.
     *
     * @return array
     */
    public function getLogs()
    {
        if (null === $this->_logs)
        {
            $this->_logs = $this->filterLogs();
        }
        return $this->_logs;
    }

    /**
     * Get count of messages.
     *
     * @return integer
     */
    public function getCountMessages()
    {
        if (null === $this->_countMessages)
        {
            $this->_countMessages = count($this->logs);
        }
        return $this->_countMessages;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->render('logging', array(
            'logs' => $this->logs
        ));
    }

    /**
     * Get filter logs.
     *
     * @return array
     */
    protected function filterLogs()
    {
        $logs = array();
        foreach ($this->owner->getLogs() as $entry)
        {            
            if (CLogger::LEVEL_PROFILE !== $entry[1] &&  false === strpos($entry[2], 'system.db.CDbCommand'))
            {
                $logs[] = $entry;
            }
        }
        return $logs;
    }
}
