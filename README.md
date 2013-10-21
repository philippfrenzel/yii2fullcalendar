yii2fullcalendar
================

JQuery Fullcalendar Yii2 Extension

JQuery from:
http://arshaw.com/fullcalendar/

License MIT

JQuery Documentation:
http://arshaw.com/fullcalendar/docs/

Yii2 Extension by <philipp@frenzel.net>

Usage
=====

Quickstart Looks like this:

'''

  $events = array();
  //Testing
  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 1;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\Th:m:s\Z');
  $events[] = $Event;

  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 2;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
  $events[] = $Event;

  ?>
  
  <?= yii2fullcalendar\yii2fullcalendar::widget(array(
      'events'=> $events,
  ));
'''

Note, that this will only view the events without any detailed view or option to add a new event.. etc.