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
        'default' => 'month',
        'editable' => false,
    ];

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
        'right'=>'month,agendaWeek,agendaDay'
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
    public $googleCalendar = true;

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
        echo Html::tag('div',$this->loading,['id' => 'loading']);
        echo Html::tag('div','',$this->options);
        $this->registerPlugin();
        echo $this->getModal();
    }

    /**
    * Registers the FullCalendar javascript assets and builds the requiered js  for the widget and the related events
    */
    protected function registerPlugin()
    {        
        $id = $this->options['id'];
        $view = $this->getView();

        $view->registerCss("#loading {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
        }");

        /** @var \yii\web\AssetBundle $assetClass */
        $assets = CoreAsset::register($view);

        //by default we load the jui theme, but if you like you can set the theme to false and nothing gets loaded....
        /*if($this->theme == true)
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
        }*/

        $js = array();

        /*if($this->ajaxEvents != NULL){
            $this->clientOptions['events'] = $this->ajaxEvents;
        }*/

        if(is_array($this->header) && isset($this->clientOptions['header']))
        {
            $this->clientOptions['header'] = array_merge($this->header,$this->clientOptions['header']);
        } else {
            $this->clientOptions['header'] = $this->header;
        }
	
	// clear existing calendar display before rendering new fullcalendar instance
	// this step is important when using the fullcalendar widget with pjax
	// $js[] = "var loading_container = jQuery('#fc-loading-div');"; // take backup of loading container
	// $js[] = "jQuery('#$id').empty().append(loading_container);"; // remove/empty the calendar container and append loading container bakup

        $cleanOptions = $this->getClientOptions();
        $js = "jQuery('#$id').fullCalendar($cleanOptions);";

        /*$ajaxjs = "$('#{$id}').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            // defaultDate: '2016-06-12',
            editable: true,
            eventLimit: true, 
            events: {
                url: 'http://www.cookingshop.com/site/jsoncalendar',
            },
            loading: function(bool) {
                $('#loading').toggle(bool);
            }
        });";*/

       /* $gcaljs = "
        $('#{$id}').fullCalendar({

            // THIS KEY WON'T WORK IN PRODUCTION!!!
            // To make your own Google API key, follow the directions here:
            // http://fullcalendar.io/docs/google_calendar/
            googleCalendarApiKey: 'AIzaSyCo5WsTFwpZTkEWmZ-fdthOr71fABBgTkU',
        
            // US Holidays
            events: 'en.usa#holiday@group.v.calendar.google.com',
            
            eventClick: function(event) {
                // opens events in a popup window
                window.open(event.url, 'gcalevent', 'width=700,height=600');
                return false;
            },
            
            loading: function(bool) {
                $('#loading').toggle(bool);
            }
            
        });";*/

        $view->registerJs($js,View::POS_READY);
    }

    /**
     * @return array the options for the text field
     */
    protected function getClientOptions()
    {
        $id = $this->options['id'];
        $options['loading'] = new JsExpression("function(isLoading, view ) {
                if(isLoading){
                    $('#loading').show();
                    $('#{$id}').hide();
                }else{
                    $('#loading').hide();
                    $('#{$id}').show();
                }

        }");
		if (count($this->events)>0)
		{
			$options['events'] = $this->events;
		}
        $options = array_merge($options, $this->clientOptions);
        return Json::encode($options);
    }

    protected function getModal(){
        return '<div id="calModal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="vertical-alignment-helper">
                <div class="modal-dialog modal-lg vertical-align-center">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 id="modal-title" class="modal-title"></h4>
                        </div>
                        <div id="modalContent"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

}
