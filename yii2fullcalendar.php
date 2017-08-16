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
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\base\Widget as elWidget;

class yii2fullcalendar extends elWidget
{

    /**
    * @var array options the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = [
        'class' => 'fullcalendar'
    ];

    /**
     * @var bool $theme default is true and will render the jui theme for the calendar
     */
    public $theme = true;

    /**
     * @var array clientOptions the HTML attributes for the widget container tag.
     */
    public $clientOptions = [
        'weekends' => true,
        'editable' => false,
    ];

    /**
     * @var string defaultView will define which view renderer will initially be used for displaying calendar events
     */
    public $defaultView = 'month';

    /**
    * Holds an array of Event Objects
    * @var array events of yii2fullcalendar\models\Event
    * @todo add the event class and write docs
    **/
    public $events = [];

    /**
     * Define the look n feel for the calendar header, known placeholders are left, center, right
     * @var array header format
     */
    public $header = [
        'center'=>'title',
        'left'=>'prev,next today',
        'right'=>'month,agendaWeek'
    ];

    /**
     * Will hold an url to json formatted events!
     * @var url to json service
     */
    public $ajaxEvents = NULL;

    /**
     * wheather the events will be "sticky" on pagination or not. Uncomment if you are loading events
	 * separately from the initial options.
     * @var boolean
     */
    //public $stickyEvents = true;

    /**
     * tell the calendar, if you like to render google calendar events within the view
     * @var boolean
     */
    public $googleCalendar = false;

    /**
     * the text that will be displayed on changing the pages
     * @var string
     */
    public $loading = 'Loading ...';

    /**
     * internal marker for the name of the plugin
     * @var string
     */
    private $_pluginName = 'fullCalendar';

    /**
     * The javascript function to us as en eventRender callback
     * @var string the javascript code that implements the eventRender function
     */
    public $eventRender = "";

    /**
     * The javascript function to us as en eventAfterRender callback
     * @var string the javascript code that implements the eventAfterRender function
     */
    public $eventAfterRender = "";

    /**
     * The javascript function to us as en eventAfterAllRender callback
     * @var string the javascript code that implements the eventAfterAllRender function
     */
    public $eventAfterAllRender = "";

     /**
     * The javascript function to us as en eventDrop callback
     * @var string the javascript code that implements the eventDrop function
     */

    public $eventDrop = "";
	
     /**
     * The javascript function to us as en eventResize callback
     * @var string the javascript code that implements the eventResize function
     */

    public $eventResize = "";

    /**
     * A js callback that triggered when the user clicks an event.
     * @var string the javascript code that implements the eventClick function
     */
    public $eventClick = "";

    /**
     * A js callback that will fire after a selection is made.
     * @var string the javascript code that implements the select function
     */
    public $select = "";

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
        //checks for the class
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'fullcalendar';
        }

        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->options['data-plugin-name'] = $this->_pluginName;

        if (!isset($this->options['class'])) {
            $this->options['class'] = 'fullcalendar';
        }

        echo Html::beginTag('div', $this->options) . "\n";
            echo Html::beginTag('div',['class'=>'fc-loading','style' => 'display:none;']);
                echo Html::encode($this->loading);
            echo Html::endTag('div')."\n";
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
        $assets = CoreAsset::register($view);

        //by default we load the jui theme, but if you like you can set the theme to false and nothing gets loaded....
        if($this->theme == true)
        {
            ThemeAsset::register($view);
        }

        if (isset($this->options['lang']))
        {
            $assets->language = $this->options['lang'];
        }

        if ($this->googleCalendar)
        {
            $assets->googleCalendar = $this->googleCalendar;
        }

        $js = array();

        if($this->ajaxEvents != NULL){
            $this->clientOptions['events'] = $this->ajaxEvents;
        }

        if(is_array($this->header) && isset($this->clientOptions['header']))
        {
            $this->clientOptions['header'] = array_merge($this->header,$this->clientOptions['header']);
        } else {
            $this->clientOptions['header'] = $this->header;
        }

	if(isset($this->defaultView) && !isset($this->clientOptions['defaultView']))
        {
            $this->clientOptions['defaultView'] = $this->defaultView;
        }

	// clear existing calendar display before rendering new fullcalendar instance
	// this step is important when using the fullcalendar widget with pjax
	$js[] = "var loading_container = jQuery('#$id .fc-loading');"; // take backup of loading container
	$js[] = "jQuery('#$id').empty().append(loading_container);"; // remove/empty the calendar container and append loading container bakup

        $cleanOptions = $this->getClientOptions();
        $js[] = "jQuery('#$id').fullCalendar($cleanOptions);";

        /**
	* Loads events separately from the calendar creation. Uncomment if you need this functionality.
	*
	* lets check if we have an event for the calendar...
        * if(count($this->events)>0)
        * {
        *    foreach($this->events AS $event)
        *    {
        *        $jsonEvent = Json::encode($event);
        *        $isSticky = $this->stickyEvents;
        *        $js[] = "jQuery('#$id').fullCalendar('renderEvent',$jsonEvent,$isSticky);";
        *    }
        * }
	*/

        $view->registerJs(implode("\n", $js),View::POS_READY);
    }

    /**
     * @return array the options for the text field
     */
    protected function getClientOptions()
    {
        $id = $this->options['id'];
        $options['loading'] = new JsExpression("function(isLoading, view ) {
                jQuery('#{$id}').find('.fc-loading').toggle(isLoading);
        }");
        if ($this->eventRender){
            $options['eventRender'] = new JsExpression($this->eventRender);
        }
        if ($this->eventAfterRender){
            $options['eventAfterRender'] = new JsExpression($this->eventAfterRender);
        }
        if ($this->eventAfterAllRender){
            $options['eventAfterAllRender'] = new JsExpression($this->eventAfterAllRender);
        }

        if ($this->eventDrop){
            $options['eventDrop'] = new JsExpression($this->eventDrop);
        }
	    
        if ($this->eventResize){
            $options['eventResize'] = new JsExpression($this->eventResize);
        }	    

        if ($this->select){
            $options['select'] = new JsExpression($this->select);
        }
        if ($this->eventClick){
            $options['eventClick'] = new JsExpression($this->eventClick);
        }
		//checks for events and loads them into the options. Comment out if loading separately.
		if (count($this->events)>0)
		{
			$options['events'] = $this->events;
		}
        $options = array_merge($options, $this->clientOptions);
        return Json::encode($options);
    }

}
