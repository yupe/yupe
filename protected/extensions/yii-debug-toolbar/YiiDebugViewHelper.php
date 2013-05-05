<?php
/**
 * YiiDebugViewHelper class file.
 */


/**
 * YiiDebugViewHelper class.
 *
 * Contains static methods that can be used in views.
 *
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugViewHelper
{
    /**
     * Splits a text by putting each line in a div.
     *
     * The second and following lines are in a block of class "details".
     */
    public static function splitLinesInBlocks($txt)
    {
        $lines = explode("\n", $txt);
        $first = array_shift($lines);
        $details = "";
        if (count($lines) > 0) {
            $details = '<div class="hidden details"><div>'
                . join("</div><div>", $lines)
                . "</div></div>\n";
        }
        return '<div>' . $first ."</div>\n" . $details;
    }
}
