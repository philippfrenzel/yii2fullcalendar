<?php

namespace yii2fullcalendar;

use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class MomentAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    public $sourcePath = '@vendor/philippfrenzel/yii2fullcalendar/dist';

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'lib/moment.min.js'
    ];

}
