<?php

/**
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 * @package Yii2Debug
 * @since 1.1.13
 */
class Yii2DbPanel extends Yii2DebugPanel
{
	/**
	 * @var bool вставлять или нет значения параметров в sql-запрос
	 */
	public $insertParamValues = true;
	/**
	 * @var bool разрешен или нет explain для sql-запросов
	 */
	public $canExplain = true;

	public function getName()
	{
		return 'Database';
	}

	public function getSummary()
	{
		$timings = $this->calculateTimings();
		$count = count($timings);
		$time = 0;
		foreach ($timings as $timing) {
			$time += $timing[4];
		}
		if (!$count) return '';
		return $this->render(dirname(__FILE__) . '/../views/panels/db_bar.php', array(
			'count' => $count,
			'time' => number_format($time * 1000) . ' ms',
		));
	}

	public function getDetail()
	{
		return $this->render(dirname(__FILE__) . '/../views/panels/db.php', array(
			'queries' => $this->getQueriesInfo(),
			'queriesCount' => count($this->calculateTimings()),
			'resume' => $this->getResumeInfo(),
			'resumeCount' => count($this->calculateResume()),
			'connectionsCount' => count($this->data['connections']),
			'connections' => $this->getConnectionsInfo(),
		));
	}

	/**
	 * @return array
	 */
	protected function getQueriesInfo()
	{
		$items = array();
		foreach ($this->calculateTimings() as $timing) {
			$items[] = array(
				'time' => date('H:i:s.', $timing[3]) . sprintf('%03d', (int)(($timing[3] - (int)$timing[3]) * 1000)),
				'duration' => sprintf('%.1f ms', $timing[4] * 1000),
				'procedure' => $this->formatSql($timing[1], $this->insertParamValues),
			);
		}
		return $items;
	}

	/**
	 * @return array
	 */
	protected function getResumeInfo()
	{
		$items = array();
		foreach ($this->calculateResume() as $item) {
			$items[] = array(
				'procedure' => $item[0],
				'count' => $item[1],
				'total' => sprintf('%.1f ms', $item[2] * 1000),
				'avg' => sprintf('%.1f ms', $item[2] * 1000 / $item[1]),
				'min' => sprintf('%.1f ms', $item[3] * 1000),
				'max' => sprintf('%.1f ms', $item[4] * 1000),
			);
		}
		return $items;
	}

	/**
	 * @return array
	 */
	protected function getConnectionsInfo()
	{
		$connections = array();
		foreach ($this->data['connections'] as $id => $connection) {
			$caption = "Component: $id ($connection[class])";
			unset($connection['class']);
			if (isset($connection['info'])) {
				foreach (explode('  ', $connection['info']) as $line) {
					list($key, $value) = explode(': ', $line, 2);
					$connection[$key] = $value;
				}
				unset($connection['info']);
			}
			$connections[$caption] = $connection;
		}
		return $connections;
	}

	private $_timings;

	/**
	 * Группировка времени выполнения sql-запросов
	 * @return array
	 */
	protected function calculateTimings()
	{
		if ($this->_timings !== null) {
			return $this->_timings;
		}
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
					$timings[$last[4]] = array(count($stack), $token, $category, $last[3], $timestamp - $last[3]);
				}
			}
		}
		$now = microtime(true);
		while (($last = array_pop($stack)) !== null) {
			$delta = $now - $last[3];
			$timings[$last[4]] = array(count($stack), $last[0], $last[2], $last[3], $delta);
		}
		ksort($timings);
		return $this->_timings = $timings;
	}

	private $_resume;

	/**
	 * Группировка sql-запросов
	 * @return array
	 */
	protected function calculateResume()
	{
		if ($this->_resume !== null) {
			return $this->_resume;
		}
		$resume = array();
		foreach ($this->calculateTimings() as $timing) {
			$duration = $timing[4];
			$query = $this->formatSql($timing[1], $this->insertParamValues);
			$key = md5($query);
			if (!isset($resume[$key])) {
				$resume[$key] = array($query, 1, $duration, $duration, $duration);
			} else {
				$resume[$key][1]++;
				$resume[$key][2] += $duration;
				if ($resume[$key][3] > $duration) $resume[$key][3] = $duration;
				if ($resume[$key][4] < $duration) $resume[$key][4] = $duration;
			}
		}
		usort($resume, array($this, 'compareResume'));
		return $this->_resume = $resume;
	}

	private function compareResume($a, $b)
	{
		if ($a[2] == $b[2]) return 0;
		return $a[2] < $b[2] ? 1 : -1;
	}

	/**
	 * Выделение sql-запроса из лога и подстановка параметров
	 * @param string $message
	 * @param bool $insertParams
	 * @return string
	 */
	public function formatSql($message, $insertParams)
	{
		$sqlStart = strpos($message, '(') + 1;
		$sqlEnd = strrpos($message , ')');
		$sql = substr($message, $sqlStart, $sqlEnd - $sqlStart);
		if (strpos($sql, '. Bound with ') !== false) {
			list($query, $params) = explode('. Bound with ', $sql);
			if (!$insertParams) return $query;
			$sql = $this->insertParamsToSql($query, $this->parseParamsSql($params));
		}
		return $sql;
	}

	/**
	 * Парсинг строки с параметрами типа (:xxx, ?)
	 * @param string $params
	 * @return array key/value
	 */
	private function parseParamsSql($params)
	{
		$binds = array();
		$pos = 0;
		while (preg_match('/((?:\:[a-z0-9\.\_\-]+)|\d+)\s*\=\s*/i', $params, $m, PREG_OFFSET_CAPTURE, $pos)) {
			$start = $m[0][1] + strlen($m[0][0]);
			$key = $m[1][0];
			if (($params{$start} == '"') || ($params{$start} == "'")) {
				$quote = $params{$start};
				$pos = $start;
				while (($pos = strpos($params, $quote, $pos + 1)) !== false) {
					$slashes = 0;
					while ($params{$pos - $slashes - 1} == '\\') $slashes++;
					if ($slashes % 2 == 0) {
						$binds[$key] = substr($params, $start, $pos - $start + 1);
						$pos++;
						break;
					}
				}
			} elseif (($end = strpos($params, ',', $start + 1)) !== false) {
				$binds[$key] = substr($params, $start, $end - $start);
				$pos = $end + 1;
			} else {
				$binds[$key] = substr($params, $start, strlen($params) - $start);
				break;
			}
		}
		return $binds;
	}

	/**
	 * Умная подстановка параметров в SQL-запрос.
	 *
	 * Поиск параметров производится за пределами строк в кавычках ["'`].
	 * Значения подставляются для параметров типа (:xxx, ?).
	 * @param string $query
	 * @param array $params
	 * @return string
	 */
	private function insertParamsToSql($query, $params)
	{
		$sql = '';
		$pos = 0;
		do {
			// Выявление ближайшей заэкранированной части строки
			$quote = '';
			if (preg_match('/[`"\']/', $query, $m, PREG_OFFSET_CAPTURE, $pos)) {
				$qchar = $m[0][0];
				$qbegin = $m[0][1];
				$qend = $qbegin;
				do {
					$sls = 0;
					if (($qend = strpos($query, $qchar, $qend + 1)) !== false) {
						while ($query{$qend - $sls - 1} == '\\') $sls++;
					} else {
						$qend = strlen($query) - 1;
					}
				} while ($sls % 2);
				$quote = substr($query, $qbegin, $qend - $qbegin + 1);
				$token = substr($query, $pos, $qbegin - $pos);
				$pos = $qend + 1;
			} else {
				$token = substr($query, $pos);
			}
			// Подстановка параметров в незаэкранированную часть SQL
			$subsql = '';
			$pind= 0;
			$tpos = 0;
			while (preg_match('/\:[a-z0-9\.\_\-]+|\?/i', $token, $m, PREG_OFFSET_CAPTURE, $tpos)) {
				$key = $m[0][0];
				if ($key == '?') $key = $pind++;
				if (isset($params[$key])) {
					$value = $params[$key];
				} else {
					$value = $m[0][0];
				}
				$subsql .= substr($token, $tpos, $m[0][1] - $tpos) . $value;
				$tpos = $m[0][1] + strlen($m[0][0]);
			}
			$subsql .= substr($token, $tpos);
			// Склейка
			$sql .= $subsql . $quote;
		} while ($quote !== '');
		return $sql;
	}

	/**
	 * @var CTextHighlighter
	 */
	private $_hl;

	/**
	 * Подсветка sql-кода
	 * @param string $sql
	 * @return string
	 */
	public function highlightSql($sql)
	{
		if ($this->_hl === null) {
			$this->_hl = Yii::createComponent(array(
				'class' => 'CTextHighlighter',
				'language' => 'sql',
				'showLineNumbers' => false,
			));
		}
		$html = $this->_hl->highlight($sql);
		return strip_tags($html, '<div>,<span>');
	}

	public function save()
	{
		$messages = Yii::getLogger()->getLogs(CLogger::LEVEL_PROFILE, 'system.db.CDbCommand.*');

		$connections = array();
		foreach (Yii::app()->getComponents() as $id => $component) {
			if ($component instanceof CDbConnection) {
				/* @var CDbConnection $component */
				$connections[$id] = array(
					'class' => get_class($component),
					'driver' => $component->getDriverName(),
				);
				try {
					$connections[$id]['server'] = $component->getServerVersion();
					$connections[$id]['info'] = $component->getServerInfo();
				} catch (Exception $e) {}
			}
		}

		return array(
			'messages' => $messages,
			'connections' => $connections,
		);
	}

	/**
	 * Return explain procedure or null
	 * @param string $query
	 * @param string $driver name
	 * @return string|null
	 */
	public static function getExplainQuery($query, $driver)
	{
		if (preg_match('/^\s*SELECT/', $query)) {
			switch ($driver) {
				case 'mysql': return 'EXPLAIN ' . $query;
				case 'pgsql': return 'EXPLAIN ' . $query;
				case 'sqlite': return 'EXPLAIN QUERY PLAN ' . $query;
				case 'oci': return 'EXPLAIN PLAN FOR ' . $query;
			}
		}
		return null;
	}

	/**
	 * Run explain procedure
	 * @param string $query
	 * @param CDbConnection $connection
	 * @return array
	 */
	public static function explain($query, $connection)
	{
		$procedure = static::getExplainQuery($query, $connection->driverName);
		if ($procedure === null) {
			throw new Exception('Explain not available');
		}
		return $connection->createCommand($procedure)->queryAll();
	}

	/**
	 * Return connection list for query
	 * @param string $query
	 * @return array connection list
	 */
	public function getExplainConnections($query)
	{
		$connections = array();
		foreach ($this->data['connections'] as $name => $connection) {
			if (static::getExplainQuery($query, $connection['driver']) !== null) {
				$connections[$name] = $connection;
			}
		}
		return $connections;
	}

	/**
	 * @param int $number
	 * @return string sql-query
	 */
	public function messageByNum($number)
	{
		foreach ($this->calculateTimings() as $timing) {
			if (!$number--) {
				return $timing[1];
			}
		}
		return null;
	}
}