<?php 

interface YQueueInterface
{
	public function add($worker, array $task);

	public function delete($id, $worker=null);

	public function flush($worker=null);
}