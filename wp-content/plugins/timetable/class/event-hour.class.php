<?php
class TT_Event_Hour
{
	public $event_hours_id;
	public $event_id;
	public $weekday_id;
	public $start;
	public $end;
	public $tooltip;
	public $before_hour_text;
	public $after_hour_text;
	public $category;
	public $available_places;
	public $slots_per_user;
	public $event_title;
	public $event_name;
	public $weekday_title;
	public $weekday_name;
	public $weekday;
	public $event;
	
	public function GetEvent()
	{
		if(is_null($this->event) && $this->event_id>0)
		{
			$this->event = TT_Event::FetchOneById($this->event_id);
		}
		return $this->event;
	}
	public function setEvent($event) { $this->event = $event; }	
	
	public function GetWeekday()
	{
		if(is_null($this->weekday) && $this->weekday_id>0)
		{
			$this->weekday = TT_Weekday::FetchOneById($this->weekday_id);
		}
		return $this->weekday;
	}
	public function SetWeekday($weekday) { $this->weekday = $weekday; }
	
	public function __construct($data = array())
	{
		$this->SetDefaults();
		
		$this->Set($data);
	}
	
	public function Set($data = array())
	{
	    if(isset($data['event_hours_id']))
	        $this->event_hours_id = $data['event_hours_id'];
	    if(isset($data['event_id']))
	        $this->event_id = $data['event_id'];
        if(isset($data['weekday_id']))
            $this->weekday_id = $data['weekday_id'];
        if(isset($data['start']))
            $this->start = $data['start'];
        if(isset($data['end']))
            $this->end = $data['end'];
        if(isset($data['tooltip']))
            $this->tooltip = $data['tooltip'];
        if(isset($data['before_hour_text']))
            $this->before_hour_text = $data['before_hour_text'];
        if(isset($data['after_hour_text']))
            $this->after_hour_text = $data['after_hour_text'];
        if(isset($data['category']))
            $this->category = $data['category'];
        if(isset($data['available_places']))
            $this->available_places = $data['available_places'];
        if(isset($data['slots_per_user']))
            $this->slots_per_user = $data['slots_per_user'];
        if(isset($data['event_title']))
            $this->event_title = $data['event_title'];
        if(isset($data['event_name']))
            $this->event_name = $data['event_name'];
        if(isset($data['weekday_title']))
            $this->weekday_title = $data['weekday_title'];
        if(isset($data['weekday_name']))
            $this->weekday_name = $data['weekday_name'];
	}

	protected function SetDefaults()
	{
		$defaults = static::GetDefaults();
		$this->event_hours_id = $defaults['event_hours_id'];
		$this->event_id = $defaults['event_id'];
		$this->weekday_id = $defaults['weekday_id'];
		$this->start = $defaults['start'];
		$this->end = $defaults['end'];
		$this->tooltip = $defaults['tooltip'];
		$this->before_hour_text = $defaults['before_hour_text'];
		$this->after_hour_text = $defaults['after_hour_text'];
		$this->category = $defaults['category'];
		$this->available_places = $defaults['available_places'];
		$this->slots_per_user = $defaults['slots_per_user'];
		$this->event_title = $defaults['event_title'];
		$this->event_name = $defaults['event_name'];
		$this->weekday_title = $defaults['weekday_title'];
		$this->weekday_name = $defaults['weekday_name'];
	}
	
	protected static function GetDefaults()
	{
		return array(
			'event_hours_id'		=> 0,
			'event_id'				=> 0,
			'weekday_id'			=> 0,
			'start'					=> '',
			'end'					=> '',
			'tooltip'				=> '',
			'before_hour_text'		=> '',
			'after_hour_text'		=> '',
			'category'				=> '',
			'available_places'		=> 0,
			'slots_per_user'		=> 1,
			'event_title'			=> '',
			'event_name'			=> '',
			'weekday_title'			=> '',
			'weekday_name'			=> '',
		);
	}
	
	public static function Fetch($args = array())
	{
		$defaults = static::GetDefaultFetchArgs();
		$args = shortcode_atts($defaults, $args);
		
		global $wpdb;
		$query = '';
		$queryArgs = array();

		$query .= 
		'SELECT 
			event_hour.event_hours_id,
			event_hour.event_id,
			event_hour.weekday_id,
			TIME_FORMAT(event_hour.start, "%H:%i") AS start, 
			TIME_FORMAT(event_hour.end, "%H:%i") AS end, 
			event_hour.tooltip,
			event_hour.before_hour_text,
			event_hour.after_hour_text,
			event_hour.category,
			event_hour.available_places,
			event_hour.slots_per_user,
			event.post_title AS event_title,
			event.post_name as event_name,
			weekday.post_title AS weekday_title,
			weekday.post_name as weekday_name
		FROM 
			' . $wpdb->prefix . 'event_hours AS event_hour
		LEFT JOIN
			' . $wpdb->posts . ' AS event ON(event_hour.event_id=event.ID)
		LEFT JOIN
			' . $wpdb->posts . ' AS weekday ON(event_hour.weekday_id=weekday.ID)
		WHERE 
			1 = 1';
		if($args['event_hour_id'])
		{
		    $query .=
		    ' AND event_hour.event_hours_id IN (';
		    $temp = array();
		    foreach($args['event_hour_id'] as $val)
		    {
		        $temp[] = '%d';
		        $queryArgs[] = (int)$val;
		    }
		    $query .= implode(',', $temp);
		    $query .= ')';
		}
		if($args['event'])
		{
			$query .= 
				' AND event.post_name IN (';
			$temp = array();
			foreach($args['event'] as $val)
			{
				$temp[] = '%s';
				$queryArgs[] = $val;
			}
			$query .= implode(',', $temp);
			$query .= ')';
		}
		if($args['weekday'])
		{
			$query .= 
				' AND weekday.post_name IN (';
			$temp = array();
			foreach($args['weekday'] as $val)
			{
				if($val=='')
					continue;
				$temp[] = '%s';
				$queryArgs[] = $val;
			}
			$query .= implode(',', $temp);
			$query .= ')';
		}
		$query = $wpdb->prepare($query, $queryArgs);
		$result = $wpdb->get_results($query, 'ARRAY_A');
		if(!$result)
			return null;
		$eventHours = array();
		foreach($result as $key=>$val)
			$eventHours[] = new static($val);
		
		return $eventHours;
	}
	
	public static function FetchById($id)
	{
	    $eventHours = static::Fetch(array('event_hour_id' => array($id)));
	    if(count($eventHours)==1)
	        return $eventHours[0];
	    else 
	        return null;
	}
	
	public static function GetDefaultFetchArgs()
	{
		$defaults = array(
		    'event_hour_id' => array(),
			'event' => array(),
			'weekday' => array(),
		);
		return $defaults;
	}
	
	public static function Insert(TT_Event_Hour $eventHour)
	{
		global $wpdb;
		$query = '';
		$queryFieldsClause = array();
		$queryValuesClause = array();
		$queryArgs = array();
		
		if($eventHour->event_id>0)
		{
			$queryFieldsClause[] = "event_id";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->event_id;
		}
		if($eventHour->weekday_id>0)
		{
			$queryFieldsClause[] = "weekday_id";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->weekday_id;
		}
		if($eventHour->start!='')
		{
			$queryFieldsClause[] = "start";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->start;
		}
		if($eventHour->end!='')
		{
			$queryFieldsClause[] = "end";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->end;
		}
		if($eventHour->tooltip!='')
		{
			$queryFieldsClause[] = "tooltip";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->tooltip;
		}
		if($eventHour->before_hour_text!='')
		{
			$queryFieldsClause[] = "before_hour_text";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->before_hour_text;
		}
		if($eventHour->after_hour_text!='')
		{
			$queryFieldsClause[] = "after_hour_text";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->after_hour_text;
		}
		if($eventHour->category!='')
		{
			$queryFieldsClause[] = "category";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->category;
		}
		if($eventHour->available_places>=0)
		{
			$queryFieldsClause[] = "available_places";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->available_places;
		}
		if($eventHour->slots_per_user>=0)
		{
			$queryFieldsClause[] = "slots_per_user";
			$queryValuesClause[] = "%s";
			$queryArgs[] = $eventHour->slots_per_user;
		}
		
		$queryFieldsClause = implode(", ", $queryFieldsClause);
		$queryValuesClause = implode(", ", $queryValuesClause);
		
		$query .= "INSERT INTO `" . $wpdb->prefix . "event_hours`
			(" . $queryFieldsClause . ") 
			VALUES(" . $queryValuesClause . ")";
		
		$query = $wpdb->prepare($query, $queryArgs);
		$result = $wpdb->query($query);
		if($result)
			return $wpdb->insert_id;
		else
			false;
	}
	
	public static function Update(TT_Event_Hour $eventHour)
	{
		global $wpdb;
		$query = '';
		$querySetClause = array();
		$queryArgs = array();
		
		if($eventHour->event_id>0)
		{
			$querySetClause[] = "event_id = %s";
			$queryArgs[] = $eventHour->event_id;
		}
		if($eventHour->weekday_id>0)
		{
			$querySetClause[] = "weekday_id = %s";
			$queryArgs[] = $eventHour->weekday_id;
		}
		if($eventHour->start!='')
		{
			$querySetClause[] = "start = %s";
			$queryArgs[] = $eventHour->start;
		}
		if($eventHour->end!='')
		{
			$querySetClause[] = "end = %s";
			$queryArgs[] = $eventHour->end;
		}
		if($eventHour->tooltip!='')
		{
			$querySetClause[] = "tooltip = %s";
			$queryArgs[] = $eventHour->tooltip;
		}
		if($eventHour->before_hour_text!='')
		{
			$querySetClause[] = "before_hour_text = %s";
			$queryArgs[] = $eventHour->before_hour_text;
		}
		if($eventHour->after_hour_text!='')
		{
			$querySetClause[] = "after_hour_text = %s";
			$queryArgs[] = $eventHour->after_hour_text;
		}
		if($eventHour->category!='')
		{
			$querySetClause[] = "category = %s";
			$queryArgs[] = $eventHour->category;
		}
		if($eventHour->available_places>=0)
		{
			$querySetClause[] = "available_places = %s";
			$queryArgs[] = $eventHour->available_places;
		}
		if($eventHour->slots_per_user>=0)
		{
			$querySetClause[] = "slots_per_user = %s";
			$queryArgs[] = $eventHour->slots_per_user;
		}
		$querySetClause = implode(", ", $querySetClause);
		
		$query .= "UPDATE `" . $wpdb->prefix . "event_hours`
			 SET " . $querySetClause . "
			 WHERE event_hours_id = %s";
		$queryArgs[] = $eventHour->event_hours_id;
		
		$query = $wpdb->prepare($query, $queryArgs);
		
		$result = $wpdb->query($query);
		return $result;
	}
	
	public static function Exists($Id)
	{
		global $wpdb;
		$query = '';
		$queryArgs = array();
		
		$query .= "SELECT event_hours_id
			 FROM `" . $wpdb->prefix . "event_hours`
			 WHERE event_hours_id=%s ";
		$queryArgs[] = $Id;
				
		$query = $wpdb->prepare($query, $queryArgs);
		$result = $wpdb->get_var($query);
		return $result;
	}
	
}
