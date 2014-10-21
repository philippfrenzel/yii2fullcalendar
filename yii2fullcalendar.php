<?php

 /**
 * This class is used to embed FullCalendar JQuery Plugin to my Yii2 Projects
 * @copyright Frenzel GmbH - www.frenzel.net
 * @link http://www.frenzel.net
 * @author Philipp Frenzel <philipp@frenzel.net>
 *
 */

namespace yii2fullcalendar;

use Yii;
use yii\base\Model;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget as elWidget;

class yii2fullcalendar extends elWidget
{

    /**
    * @var array options the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = array(
        'class' => 'fullcalendar',
    );

    /**
     * @var array clientOptions the HTML attributes for the widget container tag.
     */
    public $clientOptions = array(
        'weekends' => true,
        'default' => 'month',
        'editable' => false,
    );

    /**
    * Holds an array of Event Objects
    * @var array events of yii2fullcalendar\models\Event
    * @todo add the event class and write docs
    **/
    public $events = array();

    /**
     * Define the look n feel for the calendar header, known placeholders are left, center, right
     * @var array header format
     */
    public $header = array(
        'center'=>'title',
        'left'=>'prev,next today',        
        'right'=>'month,agendaWeek'
    );

    /**
     * Will hold an url to json formatted events!
     * @var url to json service
     */
    public $ajaxEvents = NULL;
    
    /**
     * wheather the events will be "sticky" on pagination or not
     * @var boolean
     */
    public $stickyEvents = true;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        //checks for the element id
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::endTag('div')."\n";
        $this->registerPlugin();
    }

    /**
    * Registers the FullCalendar javascript assets and builds the requiered js  for the widget and the related events
    */
    protected function registerPlugin()
    {
        $id = $this->options['id'];
        $view = $this->getView();

        /** @var \yii\web\AssetBundle $assetClass */
        CoreAsset::register($view);

        $js = array();

        if($this->ajaxEvents != NULL){
            $this->clientOptions['events'] = $this->ajaxEvents;
        }

        if(is_array($this->header)){
            $this->clientOptions['header'] = $this->header;
        }

        $cleanOptions = Json::encode($this->clientOptions);
        $js[] = "$('#$id').fullCalendar($cleanOptions);";

        //lets check if we have an event for the calendar...
        if(count($this->events)>0){
            foreach($this->events AS $event){
                $jsonEvent = Json::encode($event);
                $isSticky = $this->stickyEvents;
                $js[] = "$('#$id').fullCalendar('renderEvent',$jsonEvent,$isSticky);";
            }
        }
        
        $view->registerJs(implode("\n", $js),View::POS_READY);
    }

}
