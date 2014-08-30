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
    public $css = array(
        'css/fullcalendar.css',
        'css/fullcalendar.print.css',
    );

    /**
     * [$js description]
     * @var array
     */
    public $js = array(
        'js/fullcalendar.js',
        'js/gcal.js',
        'js/lang-all.js',
        'js/lib/moment.min.js',
    );
    
    /**
     * [$depends description]
     * @var array
     */
    public $depends = array(
        'yii\jui\CoreAsset',
        'yii\jui\ThemeAsset',
        'yii\jui\EffectAsset',
        'yii\jui\ResizableAsset',
        'yii\jui\DraggableAsset',
        'yii\jui\DroppableAsset',
        'yii\jui\SelectableAsset'
    );
}
