<?php

namespace yii2fullcalendar;

use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class CoreAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    public $sourcePath = '@yii2fullcalendar/assets';
    
    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'css/fullcalendar.css',
    ];

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'js/lib/moment.min.js',
        'js/fullcalendar.js',
        'js/gcal.js',
        'js/lang-all.js',
    ];
    
    /**
     * [$depends description]
     * @var array
     */
    public $depends = [
        'yii2fullcalendar\PrintAsset',
        'yii\jui\JuiAsset'
    ];
}
