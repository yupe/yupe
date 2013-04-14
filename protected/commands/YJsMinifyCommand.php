<?php
/**
 *    YJsMinifyCommand - console command for Yii framework to minify JavaScript files
 *
 *
 *    YJsMinifyCommand uses JSMin.php (http://github.com/rgrove/jsmin-php/blob/master/jsmin.php) for minify
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @version 0.1
 * @link http://allframeworks.ru
 * @example php /path/to/commandRunner.php YJsMinify /path/to/web/script/foler js min all
 *       - minify all files in '/path/to/web/script/foler'
 *       - find all files with 'js' extension
 *       - add suffix 'min' to minified files
 *       - create combined file 'all.min.js' (name 'all' - as param)
 *
 * @license BSD License
 * @package  cli.commands
 * @category cli-command
 *
 * @todo - рекурсивный обход каталогов
 * @todo - сделать вывод более читаемым (man printf)
 * @todo - перевести текст =) My English is bad =(
 * @todo - опция - только объединить (без минификации)
 *
 */
include_once'JSMin.php';

class YJsMinifyCommand extends CConsoleCommand
{
    public function getHelp()
    {
        return <<< EOD


USAGE
   php /path/to/commandRunner.php YJsMinify <path-to-dir-with-js-files> <file-extension-for-minify> <minified-file-suffix> <combine-in-one-file>

DESCRIPTION
   minify and/or combine JavaScript files in specified directory using JSMin.php (http://github.com/rgrove/jsmin-php/blob/master/jsmin.php)

PARAMETRS
   * <path-to-dir-with-js-files> - directory with js-files;
   * <file-extension-for-minify> - file extension for minify, default - 'js';
   * <minified-file-suffix>      - suffix for minified files, default - 'min';
   * <combine-in-one-file>       - if this param is set - all files will be combined into one (<combine-in-one-file>.<minified-file-suffix>.<file-extension-for-minify>);


EOD;
    }

    public function run($args)
    {
        if (!count($args))
        {
            echo $this->getHelp();
            die();
        }

        $jsWebDir = rtrim(array_shift($args), DIRECTORY_SEPARATOR);

        $jsFileExt = array_shift($args) ? : 'js';

        $jsMinSuffix = array_shift($args) ? : 'min';

        $combine = array_shift($args) ? : false;

        echo "\n\n\n";
        echo "I will minify js-files (*.$jsFileExt) in '$jsWebDir' directory !\n\n";


        if (!is_dir($jsWebDir) || !is_writable($jsWebDir))
        {
            die("\n!!!! Can't access $jsWebDir directory, check path and access rights! !!!!!\n");
        }

        $rawFiles = glob("$jsWebDir/*.$jsFileExt");

        $file = array();

        if (count($rawFiles))
        {
            echo "I will add '$jsMinSuffix' suffix to minified files!\n\n";

            echo "Found " . count($rawFiles) . " files\n";

            $totalSize = 0;

            foreach ($rawFiles as $f)
            {
                $file[$f] = filesize($f);
                echo basename($f) . ' ===> ' . $file[$f] . " bytes\n";
                $totalSize += $file[$f];
            }

            echo "===== Without compress/minify: $totalSize bytes ======\n\n\n\n";

            echo "\n===== GoGoGoGo! Compress them all !!! ===== \n\n";

            $totalMinSize = 0;

            $combineFileName = $combineContent = '';

            foreach ($rawFiles as $rf)
            {
                $minFileContents = JSMin::minify(file_get_contents($rf));

                if ($combine)
                {
                    $combineContent .= $minFileContents;
                }

                $minFileName = rtrim(basename($rf), $jsFileExt) . $jsMinSuffix . '.' . $jsFileExt;

                $minFileSize = file_put_contents(dirname($rf) . DIRECTORY_SEPARATOR . $minFileName, $minFileContents);
                $totalMinSize += $minFileSize;

                echo $minFileName . ' ===> ' . $minFileSize . " bytes (" . round(($file[$rf] - $minFileSize) / 100, 2) . "%)\n";
            }

            echo "\n\n===== After compress/minify: $totalMinSize bytes ======\n\n";

            if ($combine)
            {
                $combineFileName = "$combine.$jsMinSuffix.$jsFileExt";
                $combineFileSize = file_put_contents($jsWebDir . DIRECTORY_SEPARATOR . $combineFileName, $combineContent);
                echo "===== Created combined file '$jsWebDir/$combineFileName', size: $combineFileSize bytes ====== \n\n";
            }

            $totalPercent = round(($totalSize - $totalMinSize) / 100);

            $diffSize = $totalSize - $totalMinSize;

            echo "===== Size of your scripts is reduced by " . $totalPercent . '% (' . $diffSize . " bytes) ======\n\n";

            echo "\nThanks for minifying js-files, your users will be happy!!!\n";

            echo "\np.s. don't forget to minify css-files too!!!\n";

            echo "\np.p.s. use NGINX to serve static files =) !!!\n";

            echo "\np.p.s. Follow me on twitter http://twitter.com/xomaa !!!\n";

            echo "\nПока!!!\n\n\n";

        }
        else
        {
            echo "\n !!! Files '*.$jsFileExt' in directory '$jsWebDir' not found !!! \n\n\n";
            exit;
        }

    }
}

?>