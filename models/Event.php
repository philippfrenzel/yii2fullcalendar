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
   * The text on an event's element
   * @var string
   */
  public $title;

  /**
   * The description text for an event
   * @var string
   */
   public $description;

  /**
   * Whether an event occurs at a specific time-of-day. This property affects whether an event's time is shown. Also, in the agenda views, determines if it is displayed in the "all-day" section.
   * If this value is not explicitly specified, allDayDefault will be used if it is defined.
   * If all else fails, FullCalendar will try to guess. If either the start or end value has a "T" as part of the ISO8601 date string, allDay will become false. Otherwise, it will be true.
   * Don't include quotes around your true/false. This value is a boolean, not a string!
   * @var boolean
   */
  public $allDay;

  /**
   * The date/time an event begins. Required.
   * A Moment-ish input, like an ISO8601 string. Throughout the API this will become a real Moment object.
   * @var datetime
   */
  public $start;

  /**
   * The exclusive date/time an event ends. Optional.
   * A Moment-ish input, like an ISO8601 string. Throughout the API this will become a real Moment object.
   * It is the moment immediately after the event has ended. For example, if the last full day of an event is Thursday, the exclusive end of the event will be 00:00:00 on Friday!
   * @var datetime
   */
  public $end;

  /**
   * The range of dates that an event is to show on the calendar.
   * Used with a function to check the dates in eventRender against the range and only render
   * the dates that fall within the range.
   * @var range
   */
  public $ranges;

  /**
   * Day of Week settings for repeating events. Enter the numerical days of the week ex. [1,4] would repeat on Monday and Thursday.
   * @var array
   */
   public $dow;

  /**
   * A URL that will be visited when this event is clicked by the user. For more information on controlling this behavior, see the eventClick callback.
   * @var [type]
   */
  public $url;

  /**
   * A CSS class (or array of classes) that will be attached to this event's element.
   * @var [type]
   */
  public $className;

  /**
   * Overrides the master editable option for this single event.
   * @var boolean
   */
  public $editable;

  /**
   * Overrides the master eventStartEditable option for this single event.
   * @var [type]
   */
  public $startEditable;

  /**
   * Overrides the master eventDurationEditable option for this single event.
   * @var [type]
   */
  public $durationEditable;

  /**
   * A reference to the event source that this event came from.
   * @var [type]
   */
  public $source;

  /**
   * Sets an event's background and border color just like the calendar-wide eventColor option.
   * @var [type]
   */
  public $color;

  /**
   * Sets an event's background color just like the calendar-wide eventBackgroundColor option.
   * @var [type]
   */
  public $backgroundColor;

  /**
   * Sets an event's border color just like the the calendar-wide eventBorderColor option.
   * @var [type]
   */
  public $borderColor;

  /**
   * Sets an event's text color just like the calendar-wide eventTextColor option.
   * @var [type]
   */
  public $textColor;

  /**
   * the unique resource for the event
   */
  public $resourceId;

  /**
  * Sets an event's non-standard fields. FullCalendar will not modify or delete
  * these fields. For example, developers often include a description field for
  * use in callbacks such as eventRender.
  *
  * @since 2017.01.18
  * @author @markebjones
  * @see https://fullcalendar.io/docs/event_data/Event_Object/
  */
  public $nonstandard;

  public function rules()
  {
    return [
      [['id', 'resourceId'], 'integer'],
      ['title, allDay, start, end, url, className, source, color, backgroundColor, borderColor, textColor, nonstandard', 'safe'],
      ['editable, startEditable, durationEditable', 'boolean'],
    ];
  }

}
