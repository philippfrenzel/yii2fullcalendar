<?php

namespace yii2fullcalendar;

use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class PrintAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    public $sourcePath = '@bower/fullcalendar';
    
    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'css/fullcalendar.print.css'
    ];

    /**
     * options for the css file beeing published
     * @var [type]
     */
    public $cssOptions = [
    	'media' => 'print'
    ];

    public function init()
    {
        parent::init();
        $this->publishOptions['beforeCopy'] = function ($from, $to) {
            $dirname = basename(dirname($from));
            return $dirname === 'js' || $dirname === 'css';
        };
    }
}

