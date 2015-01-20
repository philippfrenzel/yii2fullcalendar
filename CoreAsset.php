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
    public $sourcePath = '@bower/fullcalendar';

    /**
     * [$autoGenerate description]
     * @var boolean
     */
    public $autoGenerate = true;
    
    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'fullcalendar.css',
    ];

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'fullcalendar.js',
        'gcal.js',
        'lang-all.js',
    ];
    
    /**
     * [$depends description]
     * @var array
     */
    public $depends = [
        'yii2fullcalendar\MomentAsset',
        'yii2fullcalendar\PrintAsset',
        'yii\jui\JuiAsset'
    ];

}
