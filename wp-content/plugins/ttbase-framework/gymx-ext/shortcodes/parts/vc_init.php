<?php

// Map Shortcodes ----------------------------------------------------------------------->

require_once( plugin_dir_path( __FILE__ ) . 'timetable_vc.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-grid_vc.php' );
require_once( plugin_dir_path( __FILE__ ) . 'trainer-grid_vc.php' );

if (function_exists('timetable_events_settings')) {
    require_once( plugin_dir_path( __FILE__ ) . 'events-grid_vc.php' );
}