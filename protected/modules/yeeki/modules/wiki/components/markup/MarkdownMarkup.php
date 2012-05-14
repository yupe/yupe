<?php
/**
 * MarkdownMarkup
 *
 * Processes markdown markup.
 */
class MarkdownMarkup extends AbstractMarkup
{
	/**
	 * Process a string with markup
	 *
	 * @abstract
	 * @param string $input
	 * @return string $output
	 */
	protected function processMarkup($input)
	{
		$md = new CMarkdownParser();
		return $md->transform($input);
	}
}
