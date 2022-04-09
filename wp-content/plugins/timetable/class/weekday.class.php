<?php
class TT_Weekday extends TT_Post
{
	public static function GetDefaultFetchArgs()
	{
		$defaults = array(
			'post_type' => 'timetable_weekdays',
		);
		$parent_defaults = parent::GetDefaultFetchArgs();
		$defaults += $parent_defaults;		
		return $defaults;
	}
	
	protected static function GetDefaultCreateArgs()
	{
		$defaults = array(
			'post_type' => 'timetable_weekdays',
		);
		$parent_defaults = parent::GetDefaultCreateArgs();
		$defaults += $parent_defaults;
		return $defaults;
	}
}