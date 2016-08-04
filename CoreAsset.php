<?php

namespace yii2fullcalendar;

use Yii;
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
    public $sourcePath = '@vendor/philippfrenzel/yii2fullcalendar/dist';

    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'fullcalendar.css',
        'calDisplay.css',
    ];

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'fullcalendar.js',        
        'gcal.js',
        'calFunct.js',
    ];
    
    /**
     * [$depends description]
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii2fullcalendar\MomentAsset',
        'yii2fullcalendar\PrintAsset'
    ];

}
