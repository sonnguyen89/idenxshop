<?php

// Include all shortcode parts
require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/shortcodes/parts/timetable.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/shortcodes/parts/class-grid.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/shortcodes/parts/trainer-grid.php' );

if (function_exists('timetable_events_settings')) {
    require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/shortcodes/parts/events-grid.php' );
}