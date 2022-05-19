<?php
/**
 * searchform.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 * 
 */
 ?>
<div class="search_form">
	<form class="search-form" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<div class="form_group">
			<input class="form_control" type="text" name="s" placeholder="<?php esc_attr_e('Search...', 'chakta') ?>" autocomplete="off">
			<button type="submit" class="search-icon" name="submit" value="Submit"><i class="far fa-search"></i></button>
		</div>
	</form>
</div>