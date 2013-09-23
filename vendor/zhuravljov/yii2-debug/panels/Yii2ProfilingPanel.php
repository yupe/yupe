<?php

/**
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 * @package Yii2Debug
 * @since 1.1.13
 */
class Yii2ProfilingPanel extends Yii2DebugPanel
{
	public function getName()
	{
		return 'Profiling';
	}

	public function getSummary()
	{
		return $this->render(dirname(__FILE__) . '/../views/panels/profiling_bar.php', array(
			'time' => number_format($this->data['time'] * 1000) . ' ms',
			'memory' => sprintf('%.1f MB', $this->data['memory'] / 1048576),
		));
	}

	public function getDetail()
	{
		$messages = $this->data['messages'];
		$timings = array();
		$stack = array();
		foreach ($messages as $i => $log) {
			list($token, , $category, $timestamp) = $log;
			$log[4] = $i;
			if (strpos($token, 'begin:') === 0) {
				$log[0] = $token = substr($token, 6);
				$stack[] = $log;
			} elseif (strpos($token, 'end:') === 0) {
				$log[0] = $token = substr($token, 4);
				if (($last = array_pop($stack)) !== null && $last[0] === $token) {
					$timings[$last[4]] = array(count($stack), $token, $category, $timestamp - $last[3]);
				}
			}
		}
		$now = microtime(true);
		while (($last = array_pop($stack)) !== null) {
			$delta = $now - $last[3];
			$timings[$last[4]] = array(count($stack), $last[0], $last[2], $delta);
		}
		ksort($timings);
		$items = array();
		foreach ($timings as $timing) {
			$items[] = array(
				'indent' => $timing[0],
				'procedure' => $timing[1],
				'category' => $timing[2],
				'time' => sprintf('%.1f ms', $timing[3] * 1000),
			);
		}
		return $this->render(dirname(__FILE__) . '/../views/panels/profiling.php', array(
			'items' => $items,
			'time' => number_format($this->data['time'] * 1000) . ' ms',
			'memory' => sprintf('%.1f MB', $this->data['memory'] / 1048576),
		));
	}

	public function save()
	{
		$messages = Yii::getLogger()->getLogs(CLogger::LEVEL_PROFILE);
		return array(
			'memory' => memory_get_peak_usage(),
			'time' => microtime(true) - YII_BEGIN_TIME,
			'messages' => $messages,
		);
	}
}