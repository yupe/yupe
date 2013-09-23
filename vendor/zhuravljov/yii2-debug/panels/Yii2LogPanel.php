<?php

/**
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 * @package Yii2Debug
 * @since 1.1.13
 */
class Yii2LogPanel extends Yii2DebugPanel
{
	public function getName()
	{
		return 'Logs';
	}

	public function getSummary()
	{
		$errorCount = 0;
		$warningCount = 0;
		foreach ($this->data['messages'] as $log) {
			$level = $log[1];
			if ($level == CLogger::LEVEL_ERROR) $errorCount++;
			elseif ($level == CLogger::LEVEL_WARNING) $warningCount++;
		}
		return $this->render(dirname(__FILE__) . '/../views/panels/log_bar.php', array(
			'count' => count($this->data['messages']),
			'errorCount' => $errorCount,
			'warningCount' => $warningCount,
		));
	}

	public function getDetail()
	{
		foreach ($this->data['messages'] as $i => $log) {
			list ($message, $level, $category, $time) = $log;
			$time = date('H:i:s.', $time) . sprintf('%03d', (int)(($time - (int)$time) * 1000));
			$traces = array();
			if (($lines = explode("\nStack trace:\n", $message, 2)) !== false) {
				$message = $lines[0];
				if (isset($lines[1])) {
					$traces = array_merge(
						array('Stack trace:'),
						explode("\n", $lines[1])
					);
				} elseif (($lines = explode("\nin ", $message)) !== false) {
					$message = array_shift($lines);
					$traces = $lines;
				}
			}
			$this->data['messages'][$i] = array($message, $level, $category, $time, $traces);
		}
		return $this->render(dirname(__FILE__) . '/../views/panels/log.php');
	}

	public function save()
	{
		$messages = Yii::getLogger()->getLogs(implode(',', array(
			CLogger::LEVEL_ERROR,
			CLogger::LEVEL_INFO,
			CLogger::LEVEL_WARNING,
			CLogger::LEVEL_TRACE,
		)));
		return array(
			'messages' => $messages,
		);
	}
}