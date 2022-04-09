<?php
class TT_Post
{
	public $ID;
	public $post_title;
	public $post_name;
	public $post_status;
	public $post_type;
	public $menu_order;
	
	public function __construct()
	{
		$this->SetDefaults();
	}
	
	public static function CreateFromWpObject(WP_Post $WpPost)
	{
		$post = new static();
		$post->ID = $WpPost->ID;
		$post->post_title = $WpPost->post_title;
		$post->post_name = $WpPost->post_name;
		$post->post_status = $WpPost->post_status;
		$post->post_type = $WpPost->post_type;
		$post->menu_order = $WpPost->menu_order;
		return $post;
	}
	
	public static function Insert(TT_Post $post)
	{
		$args = array(
			'post_title'		=> $post->post_title,
			'post_name'			=> $post->post_name,
			'post_type'			=> $post->post_type,
			'post_status'		=> $post->post_status,
			'menu_order'		=> $post->menu_order,
		);
		
		$result = wp_insert_post($args);
		return $result;
	}
	
	public static function Fetch($args = array())
	{
		$defaults = static::GetDefaultFetchArgs();
		$args += $defaults;
		
		$result = get_posts($args);
		if(!$result)
			return null;
		
		$posts = array();
		foreach($result as $key=>$WpPost)
			$posts[] = static::CreateFromWpObject($WpPost);
		return $posts;
	}
	
	public static function FetchOne($args = array())
	{
		$result = static::Fetch($args);
		if(is_null($result))
			return null;
		return $result[0];
	}
	
	public static function FetchOneById($Id)
	{
		return static::FetchOne(array(
			'post__in'	=> array($Id),
		));
	}
	
	protected function SetDefaults()
	{
		$defaults = static::GetDefaults();
		$this->ID = $defaults['ID'];
		$this->post_title = $defaults['post_title'];
		$this->post_name = $defaults['post_name'];
		$this->post_type = $defaults['post_type'];
		$this->post_status = $defaults['post_status'];
		$this->menu_order = $defaults['menu_order'];
	}
	
	protected static function GetDefaults()
	{
		return array(
			'ID'				=> 0,
			'post_title'		=> '',
			'post_name'			=> '',
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'menu_order'		=> 0,
		);
	}
	
	protected static function GetDefaultFetchArgs()
	{
		$defaults = array(
			'posts_per_page' => -1,
			'nopaging' => true,
			'orderby' => 'date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish',
		);
		return $defaults;
	}
	
	protected static function GetDefaultCreateArgs()
	{
		$defaults = array(
			'post_type' => 'post',
			'post_status'	=> 'publish',
		);
		return $defaults;
	}
	
	
}