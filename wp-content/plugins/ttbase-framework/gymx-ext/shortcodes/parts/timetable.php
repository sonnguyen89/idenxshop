<?php
// Class Grid -------------------------------------------------------------------------- >
function ttbase_framework_timetable_shortcode($atts) {
	
	extract(shortcode_atts(array(
		"class" => "",
		"class_category" => "",
		"filter_style" => "",
		"mode" => "",
		"hour_category" => "",
		"hour_minute_separator" => ".",
	), $atts));
	$classes_array = array_filter(array_map('trim', explode(",", $class)));
	$class_category_array = array_filter(array_map('trim', explode(",", $class_category)));	

	$output = '';
	$outputSelect = '';
	$output .= '<div class="timetable-tabs">';
	if($filter_style=="dropdown_list")
	{
		$outputSelect = '<select class="timetable_dropdown_navigation ">
						<option value="#all-classes">' . esc_html__("All", 'ttbase-framework') . '</option>';
	}
	$output .= '<ul class="clearfix tabs_navigation"' . ($filter_style=="dropdown_list" ? ' style="display: none;"' : '') . '>
			<li>
				<a href="#all-classes" title="' . esc_html__("All", 'ttbase-framework') . '">
					' . esc_html__("All", 'ttbase-framework') . '
				</a>
			</li>';
	if(empty($class_category))
	{
		//filter by classes
		$classes_array_count = count($classes_array);
		for($i=0; $i<$classes_array_count; $i++)
		{
			query_posts(array(
				"name" => $classes_array[$i],
				'post_type' => 'classes',
				'post_status' => 'publish'
			));
			if(have_posts())
			{
				the_post();
				if($filter_style=="dropdown_list")
					$outputSelect .= '<option value="#' . $classes_array[$i] . '">' . get_the_title() . '</option>';
				$output .= '<li>
					<a href="#' . $classes_array[$i] . '" title="' . esc_attr(get_the_title()) . '">
						' . get_the_title() . '
					</a>
				</li>';
			}
		}
	} 
	else
	{
		//filter by class categories
		$class_category_array_count = count($class_category_array);
		for($i=0; $i<$class_category_array_count; $i++)
		{
			$class_category_info = get_terms(
				array(
					"class_category"
				), 
				array(
					"slug" => $class_category_array[$i],	
				)
			);
			if(!empty($class_category_info[0]))
			{
				if($filter_style=="dropdown_list")
					$outputSelect .= '<option value="#' . $class_category_info[0]->slug . '">' . $class_category_info[0]->name . '</option>';
				$output .= '<li>
					<a href="#' . $class_category_info[0]->slug . '" title="' . esc_attr($class_category_info[0]->name) . '">
						' . $class_category_info[0]->name . '
					</a>
				</li>';
			}
		}
		//get classes for each class category	
		if(!empty($class_category))
		{
			$classes_array = array();
			$classes_array_by_category = array();
			global $post;
			foreach($class_category_array as $val)
			{
				$classes_array_by_category[$val] = array();
				query_posts(array(
					'class_category' => $val,
					'post_type' => 'classes',
					'post_status' => 'publish',
					'posts_per_page' => -1,
				));
				while ( have_posts() ) : the_post();
					$classes_array[] = $post->post_name;
					$classes_array_by_category[$val][] = $post->post_name;
				endwhile;
			}
		}
	}
	if($filter_style=="dropdown_list")
		$outputSelect .= '</select>';
	$output .= '</ul>';
	$output .= $outputSelect;
	$output .= '<div id="all-classes">' . get_timetable($classes_array, $mode, $hour_category, $hour_minute_separator) . '</div>';	
	foreach((!empty($class_category) ? $classes_array_by_category : $classes_array) as $key=>$val)
		$output .= '<div id="' . (!empty($class_category) ? $key : $val) . '">' . get_timetable($val, $mode, $hour_category, $hour_minute_separator) . '</div>';
	$output .= '</div>';
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("ttbase_timetable", "ttbase_framework_timetable_shortcode");

function hour_in_array($hour, $array)
{
	$array_count = count($array);
	for($i=0; $i<$array_count; $i++)
	{
		if(!isset($array[$i]["displayed"]))
			$array[$i]["displayed"] = false;
		if(!isset($array[$i]["start"]))
			$array[$i]["start"] = false;
		if((bool)$array[$i]["displayed"]!=true && (int)$array[$i]["start"]==(int)$hour)
			return true;
	}
	return false;
}
function get_rowspan_value($hour, $array, $rowspan, $hour_minute_separator = null)
{
	$array_count = count($array);
	$found = false;
	$hours = array();
	for($i=(int)$hour; $i<(int)$hour+$rowspan; $i++)
		$hours[] = $i;
	for($i=0; $i<$array_count; $i++)
	{
		if(in_array((int)$array[$i]["start"], $hours))
		{
			$end_explode = explode($hour_minute_separator, $array[$i]["end"]);
			$end_hour = (int)$array[$i]["end"] + ((int)$end_explode[1]>0 ? 1 : 0);
			if($end_hour-(int)$hour>1 && $end_hour-(int)$hour>$rowspan)
			{
				$rowspan = $end_hour-(int)$hour;
				$found = true;
			}
		}
		
	}
	if(!$found)
		return $rowspan;
	else
		return get_rowspan_value($hour, $array, $rowspan, $hour_minute_separator);
}
function get_row_content($classes, $mode, $hour_minute_separator = null)
{
	$content = "";
	$show_link = get_theme_mod('gymx_timetable_links', 'yes');
	foreach($classes as $key=>$details)
	{
		$tooltip = "";
        $temp = explode('_',$key);
		$key = $temp[0];
		
		if(count($classes)>1)
		{
			$color = "";
			$textcolor = ""; 
			
			$color = get_post_meta($details["id"], "gymx_post_class_tt_background_color", true);
			$text_color = get_post_meta($details["id"], "gymx_post_class_tt_text_color", true);
			$content .= '<div class="timetable-class-wrapper tt-tooltip"' . ($color!="" || $text_color!="" ? ' style="' . ($color!="" ? 'background-color:' . $color . ' !important;' : '') . ($text_color!="" ? 'color:' . $text_color . ' !important;' : '') . '"': '') . '>';
		}
		
		$title_color = get_post_meta($details["id"], "gymx_post_class_tt_title_color", true);
		if ($show_link != 'no') {
			$content .= '<a' . ( $title_color!="" ? ' style="color:' . $title_color . ' !important;"' : '') . ' href="' . get_permalink($details["id"]) . '" title="' .  esc_attr($key) . '">' . $key . '</a>';
		}else {
			$content .= '<div class="class-name"' . ( $title_color!="" ? ' style="color:' . $title_color . ' !important;"' : '') . '>' . $key . '</div>';
		}
	
		$hours_count = count($details["hours"]);
		for($i=0; $i<$hours_count; $i++)
		{
			if($mode=="12h")
			{
				$hoursExplode = explode(" - ", $details["hours"][$i]);
				$details["hours"][$i] = date("h" . $hour_minute_separator . "i a", strtotime($hoursExplode[0])) . " - " . date("h" . $hour_minute_separator . "i a", strtotime($hoursExplode[1]));
			}
			$content .= ($i!=0 ? '<br />' : '');
			if($details["before_hour_text"][$i]!="")
				$content .= "<div class='before_hour_text'>" . $details["before_hour_text"][$i] . "</div>";
			$content .= $details["hours"][$i];
			if($details["after_hour_text"][$i]!="")
				$content .= "<div class='after_hour_text'>" . $details["after_hour_text"][$i] . "</div>";
			if($details["trainers"][$i]!="")
				$content .= "<div class='class_trainers'>" . $details["trainers"][$i] . "</div>";	
			$tooltip .= ($tooltip!="" && $details["tooltip"][$i]!="" ? '<br />' : '' ) . $details["tooltip"][$i];
		}
		if($tooltip!="")
		$content .= '<div class="tooltip_text"><div class="tooltip_content">' . $tooltip . '</div></div>';
		if(count($classes)>1)
		{
			$content .= '</div>';
		}
		
	}
		
		$content .= "";
	return $content;
}
function get_timetable($class = null, $mode = null, $hour_category = null, $hour_minute_separator = null)
{
	global $blog_id;
	global $wpdb;
	if($hour_category!=null)
		$hour_category = explode(",", $hour_category);
	$output = ""; 
	$query = "SELECT TIME_FORMAT(t1.start, '%H" . $hour_minute_separator . "%i') AS start, TIME_FORMAT(t1.end, '%H" . $hour_minute_separator . "%i') AS end, t1.tooltip AS tooltip, t1.before_hour_text AS before_hour_text, t1.after_hour_text AS after_hour_text, t1.trainers AS trainers, t2.ID AS class_id, t2.post_title AS class_title, t2.post_name AS post_name, t3.post_title, t3.menu_order FROM ".$wpdb->prefix."class_hours AS t1 
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.class_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID
			WHERE 
			t2.post_type='classes'
			AND t2.post_status='publish'";
	if(is_array($class) && count($class))
		$query .= "
			AND t2.post_name IN('" . join("','", $class) . "')";
	else if($class!=null)
		$query .= "
			AND t2.post_name='" . strtolower(urlencode($class)) . "'";
	if($hour_category!=null)
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='gymx_weekdays'
			ORDER BY FIELD(t3.menu_order,1,2,3,4,5,6,7), t1.start, t1.end";
	$class_hours = $wpdb->get_results($query);
	$class_hours_tt = array();
	foreach($class_hours as $class_hour)
	{
		$trainersString = "";
		if($class_hour->trainers!="")
		{
			query_posts(array( 
				'post__in' => explode(",", $class_hour->trainers),
				'post_type' => 'trainers',
				'posts_per_page' => '-1',
				'post_status' => 'publish',
				'orderby' => 'post_title',
				'order' => 'DESC'
			));
			while(have_posts()): the_post();
				$trainersString .= get_the_title() . ", ";
			endwhile;
			if($trainersString!="")
				$trainersString = substr($trainersString, 0, -2);
		}
		$class_hours_tt[($class_hour->menu_order>0 ? $class_hour->menu_order : 7)][] = array(
			"start" => $class_hour->start,
			"end" => $class_hour->end,
			"tooltip" => $class_hour->tooltip,
			"before_hour_text" => $class_hour->before_hour_text,
			"after_hour_text" => $class_hour->after_hour_text,
			"trainers" => $trainersString,
			"id" => $class_hour->class_id,
			"title" => $class_hour->class_title,
			"name" => $class_hour->post_name
		);
	}

	$output .= '<table class="timetable">
				<thead>
					<tr>
						<th></th>';
	//get weekdays
	$query = "SELECT post_title, menu_order FROM {$wpdb->posts}
			WHERE 
			post_type='gymx_weekdays'
			AND post_status='publish'
			ORDER BY FIELD(menu_order,1,2,3,4,5,6,7)";
	$weekdays = $wpdb->get_results($query);
	foreach($weekdays as $weekday)
	{
		$output .= '	<th>' . strtoupper($weekday->post_title) . '</th>';
	}
	$output .= '	</tr>
				</thead>
				<tbody>';
	//get min anx max hour
	$query = "SELECT min(TIME_FORMAT(t1.start, '%H" . $hour_minute_separator . "%i')) AS min, max(REPLACE(TIME_FORMAT(t1.end, '%H" . $hour_minute_separator . "%i'), '00" . $hour_minute_separator . "00', '24" . $hour_minute_separator . "00')) AS max FROM ".$wpdb->prefix."class_hours AS t1
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.class_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID
			WHERE 
			t2.post_type='classes'
			AND t2.post_status='publish'";
	if(is_array($class) && count($class))
		$query .= "
			AND t2.post_name IN('" . join("','", $class) . "')";
	else if($class!=null)
		$query .= "
			AND t2.post_name='" . strtolower(urlencode($class)) . "'";
	if($hour_category!=null)
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='gymx_weekdays'";
	$hours = $wpdb->get_row($query);
	$drop_columns = array();
	$l = 0;
	$max_explode = explode($hour_minute_separator, $hours->max);
	$max_hour = (int)$hours->max + ((int)$max_explode[1]>0 ? 1 : 0);
	for($i=(int)$hours->min; $i<$max_hour; $i++)
	{
		$start = str_pad($i, 2, '0', STR_PAD_LEFT) . $hour_minute_separator . '00';
		$end = str_replace("24", "00", str_pad($i+1, 2, '0', STR_PAD_LEFT)) . $hour_minute_separator . '00';
		if($mode=="12h")
		{
			$start = date("h" . $hour_minute_separator . "i a", strtotime($start));
			$end = date("h" . $hour_minute_separator . "i a", strtotime($end));
		}
		$output .= '<tr class="row_' . ($l+1) . ($l%2==0 ? ' row_gray' : '') . '">
						<td>
							' . $start . ' - ' . $end . '
						</td>';
						for($j=1; $j<=count($weekdays); $j++)
						{
							
							if(!isset($drop_columns[$i]["columns"]))
								$drop_columns[$i]["columns"] = '';
							if(!in_array($j, (array)$drop_columns[$i]["columns"]))
							{
								if(isset($class_hours_tt[$j]) && hour_in_array($i, $class_hours_tt[$j]))
								{
									$rowspan = get_rowspan_value($i, $class_hours_tt[$j], 1, $hour_minute_separator);
									if($rowspan>1)
									{
										for($k=1; $k<$rowspan; $k++)
											$drop_columns[$i+$k]["columns"][] = $j;	
									}
									$array_count = count($class_hours_tt[$j]);
									$hours = array();
									for($k=(int)$i; $k<(int)$i+$rowspan; $k++)
										$hours[] = $k;
									$classes = array();
									for($k=0; $k<$array_count; $k++)
									{
										if(in_array((int)$class_hours_tt[$j][$k]["start"], $hours))
										{
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["name"] = $class_hours_tt[$j][$k]["name"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["tooltip"][] = $class_hours_tt[$j][$k]["tooltip"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["before_hour_text"][] = $class_hours_tt[$j][$k]["before_hour_text"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["after_hour_text"][] = $class_hours_tt[$j][$k]["after_hour_text"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["trainers"][] = $class_hours_tt[$j][$k]["trainers"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["id"] = $class_hours_tt[$j][$k]["id"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["hours"][] = $class_hours_tt[$j][$k]["start"] . " - " . $class_hours_tt[$j][$k]["end"];
											$class_hours_tt[$j][$k]["displayed"] = true;
										}
									}
									$color = "";
									$text_color = "";
									$class = 'event';
									if(count($classes)==1)
									{
										$class .= ' single';
										$color = get_post_meta($classes[key($classes)]["id"], "gymx_post_class_tt_background_color", true);
										$text_color = get_post_meta($classes[key($classes)]["id"], "gymx_post_class_tt_text_color", true);
									}
									$output .= '<td' . ($color!="" || $text_color!="" ? ' style="' . ($color!="" ? 'background-color:' . $color . ' !important;' : '') . ($text_color!="" ? 'color:' . $text_color . ' !important;' : '') . '"': '') . ' class="' . $class . '"' . (count(array_filter(array_values($classes[key($classes)]['tooltip']))) ? ' tt-tooltip' : '' ) . '"' . ($rowspan>1 ? ' rowspan="' . $rowspan . '"' : '') . '>';
									$output .= get_row_content($classes, $mode, $hour_minute_separator);
									$output .= '</td>';
								}
								else
									$output .= '<td></td>';
							}
						}
		$output .= '</tr>';
		$l++;
	}
	$output .= '	<tr>
						<td colspan="8" class="last">
							<div class="tip">
								' . esc_html__("Click on the class name to get additional info", 'ttbase-framework') . '
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="timetable small">';
	$l = 0;
	foreach($weekdays as $weekday)
	{
		$weekday_fixed_number = ($weekday->menu_order>0 ? $weekday->menu_order : 7);
		if(isset($class_hours_tt[$weekday_fixed_number]))
		{
			$output .= '<h4 class="box_header' . ($l>0 ? ' mt25' : '') . '">
				' . $weekday->post_title . '
			</h4>
			<ul class="items_list dark opening_hours">';
				$class_hours_count = count($class_hours_tt[$weekday_fixed_number]);
					
				for($i=0; $i<$class_hours_count; $i++)
				{
					if($mode=="12h")
					{
						if(empty($class_hours_tt[$weekday_fixed_number][$i]))
							continue;
						$class_hours_tt[$weekday_fixed_number][$i]["start"] = date("h" . $hour_minute_separator . "i a", strtotime($class_hours_tt[$weekday_fixed_number][$i]["start"]));
						$class_hours_tt[$weekday_fixed_number][$i]["end"] = date("h" . $hour_minute_separator . "i a", strtotime($class_hours_tt[$weekday_fixed_number][$i]["end"]));
					}
					if(isset($class_hours_tt[$weekday_fixed_number][$i]))
					{
						$output .= '<li>
								<a href="' . get_permalink($class_hours_tt[$weekday_fixed_number][$i]["id"]) . '" title="' . $class_hours_tt[$weekday_fixed_number][$i]["title"] . '">
									' . $class_hours_tt[$weekday_fixed_number][$i]["title"] . '
								</a>
								<div class="value">
									' . $class_hours_tt[$weekday_fixed_number][$i]["start"] . ' - ' . $class_hours_tt[$weekday_fixed_number][$i]["end"] . '
								</div>
							</li>';
					}
				}
			$output .= '</ul>';
			$l++;
		}
	}
	$output .= '</div>';
	return $output;
}

?>