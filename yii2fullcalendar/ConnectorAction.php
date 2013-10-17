<?php

 /**
 * This class is merely used to publish a TOC based upon the headings within a defined container
 * @copyright Frenzel GmbH - www.frenzel.net
 * @link http://www.frenzel.net
 * @author Philipp Frenzel <philipp@frenzel.net>
 *
 * don't forget to add the classmap to your index file!
 *
 * Original yii version by
 * @author z_bodya
 */

namespace yii2elfinder;

// error_reporting(0);
ini_set('max_file_uploads', 50); // allow uploading up to 50 files at once
ini_set('upload_max_filesize','5MB');
ini_set('post_max_size','5MB');

// needed for case insensitive search to work, due to broken UTF-8 support in PHP
ini_set('mbstring.internal_encoding', 'UTF-8');
ini_set('mbstring.func_overload', 2);

if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set('Europe/Berlin');
}

require_once(__DIR__ . '/php/elFinderConnector.class.php');
require_once(__DIR__ . '/php/elFinder.class.php');
require_once(__DIR__ . '/php/elFinderVolumeDriver.class.php');
require_once(__DIR__ . '/php/elFinderVolumeLocalFileSystem.class.php');
require_once(__DIR__ . '/php/elFinderVolumeDropbox.class.php');

use \Yii;
use yii\base\Action;

use elFinder;
use elFinderConnector;

class ConnectorAction extends Action
{
    /**
     * @var array
     */
    public $clientOptions = array();

    public function run()
    {   
        $fm = new elFinderConnector(new elFinder($this->clientOptions));
        $fm->run();
    }
}
