<?php
/**
 * AbstractMarkup
 *
 * You should extend from this class if you want to implement custom markup
 * processor for Yeeki.
 */
abstract class AbstractMarkup extends CComponent
{
	/**
	 * @var bool if output should be processed by HTMLPurifier
	 */
	public $purify = true;

	/**
	 * Process a string with markup
	 *
	 * @abstract
	 * @param string $input
	 * @return string $output
	 */
	public function process($input)
	{
		$out = $this->processMarkup($input);
		if($this->purify)
		{
			$purifier = new CHtmlPurifier();
			$out = $purifier->purify($out);
		}
		return $out;
	}

	/**
	 * Implement this method if you're developing your own markup processor.
	 *
	 * @abstract
	 * @param string $input
	 * @return string $output
	 */
	abstract protected function processMarkup($input);
}
