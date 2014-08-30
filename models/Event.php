<?php

namespace yii2fullcalendar\models;

use yii\base\Model;

class Event extends Model
{

  /**
   * Detailed description off all fields can be found here
   * @url http://arshaw.com/fullcalendar/docs/event_data/Event_Object/
   */
  
  /**
   * the id of the shown event
   * @var integer
   */
  public $id;

  /**
   * the title, that will be displayed within the calendar entry
   * @var string
   */
  public $title;

  /**
   * is it a full day event
   * @var boolean
   */
  public $allDay;
  
  /**
   * pls check out the efullcalendar website on how this should be formatted
   * @var datetime
   */
  public $start;
  
  /**
   * pls check out the efullcalendar website on how this should be formatted
   * @var datetime
   */
  public $end;
  
  /**
   * [$url description]
   * @var [type]
   */
  public $url;
  public $className;
  public $editable;
  public $startEditable;
  public $durationEditable;
  public $source;
  public $color;
  public $backgroundColor;
  public $borderColor;
  public $textColor;

  public function rules()
  {
    return [
      ['id', 'integer'],
      ['title, allDay, start, end, url, className, source, color, backgroundColor, borderColor, textColor', 'safe'],
      ['editable, startEditable, durationEditable', 'boolean'],
    ];
  }

}
