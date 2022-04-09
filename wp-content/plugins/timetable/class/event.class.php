<?php
class TT_Event extends TT_Post
{
	
	protected static function GetDefaults()
	{
		$timetable_events_settings = timetable_events_settings();
		$defaults = array(
			'post_type'			=> $timetable_events_settings['slug'],
		);
		$parent_defaults = parent::GetDefaults();
		$defaults += $parent_defaults;
		return $defaults;
	}
	
	public static function GetDefaultFetchArgs()
	{
		$timetable_events_settings = timetable_events_settings();
		$defaults = array(
			'post_type' => $timetable_events_settings['slug'],
		);
		$parent_defaults = parent::GetDefaultFetchArgs();
		$defaults += $parent_defaults;
		return $defaults;
	}
	
	protected static function GetDefaultCreateArgs()
	{
		$timetable_events_settings = timetable_events_settings();
		$defaults = array(
			'post_type' => $timetable_events_settings['slug'],
		);
		$parent_defaults = parent::GetDefaultCreateArgs();
		$defaults += $parent_defaults;
		return $defaults;
	}
	
}