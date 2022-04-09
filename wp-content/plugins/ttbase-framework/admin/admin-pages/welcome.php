<?php
/**
 * Admin View: Page - Status Report
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ttbbase_framework_let_to_num( $size ) {
  $l   = substr( $size, -1 );
  $ret = substr( $size, 0, -1 );
  switch ( strtoupper( $l ) ) {
    case 'P':
      $ret *= 1024;
    case 'T':
      $ret *= 1024;
    case 'G':
      $ret *= 1024;
    case 'M':
      $ret *= 1024;
    case 'K':
      $ret *= 1024;
  }
  return $ret;
}

$theme_name = 'GymX';
$theme_version = '2.2.0';
?>

<div class="wrap about-wrap ttbase-wrap">

	<h1><?php echo esc_html__( "Welcome to ", 'ttbase-framework' ) . '<span class="ttbase-name">' . $theme_name . '</span>'; ?><span class="ttbase-version"><?php echo esc_attr($theme_version); ?></span></h1>

	<div class="about-text">
		<?php printf(wp_kses(__( "%s is up and running! Check that all the requirements below are fulfilled and labeled in green.<br>Enjoy and free your imagination with %s!", 'ttbase-framework' ), array( 'br' => '')), $theme_name, $theme_name); ?>
	</div>
	<h2 class="nav-tab-wrapper">
    <?php
			printf( '<a href="%s" class="nav-tab nav-tab-active">%s</a>', admin_url('admin.php?page=gymx-options'), esc_html__( "System Status", 'ttbase-framework' ) );
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=ttbase-one-click-demo-import' ), esc_html__( "Install Demo", 'ttbase-framework' ) );
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url('customize.php'), esc_html__( "Theme Options", 'ttbase-framework' ) );
		?>
	</h2>
	<table class="widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="3" data-export-label="WordPress Environment"><?php esc_html_e( 'WordPress Environment', 'ttbase-framework' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Home URL" style="width: 33%;"><?php esc_html_e( 'Home URL', 'ttbase-framework' ); ?>:</td>
				<td class="help" style="width: 15px;"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The URL of your site\'s homepage.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_url( home_url( '/' ) ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Site URL"><?php esc_html_e( 'Site URL', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The root URL of your site.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo site_url(); ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Version"><?php esc_html_e( 'WP Version', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of WordPress installed on your site.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php bloginfo('version'); ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Multisite"><?php esc_html_e( 'WP Multisite', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Whether or not you have WordPress Multisite enabled.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php if ( is_multisite() ) echo '&#10004;'; else echo '&ndash;'; ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Memory Limit"><?php esc_html_e( 'WP Memory Limit', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php
					$memory = ttbbase_framework_let_to_num( WP_MEMORY_LIMIT );

					if ( $memory < 67108864 ) {
						echo '<mark class="error">' . sprintf( wp_kses(__( '%s - We recommend setting memory to at least 64MB. See: <a href="%s" target="_blank">Increasing memory allocated to PHP</a>', 'ttbase-framework' ), array( 'a' => array( 'href' => array(),'target' => array() ) ) ), size_format( $memory ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
					}
				?></td>
			</tr>
			<tr>
				<td data-export-label="WP Debug Mode"><?php esc_html_e( 'WP Debug Mode', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Displays whether or not WordPress is in Debug Mode.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . '&#10004;' . '</mark>'; else echo '&ndash;'; ?></td>
			</tr>
			<tr>
				<td data-export-label="Language"><?php esc_html_e( 'Language', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The current language used by WordPress. Default = English', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo get_locale() ?></td>
			</tr>
		</tbody>
	</table>
	<table class="widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Server Environment"><?php esc_html_e( 'Server Environment', 'ttbase-framework' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Server Info" style="width: 33%;"><?php esc_html_e( 'Server Info', 'ttbase-framework' ); ?>:</td>
				<td class="help" style="width: 15px;"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Information about the web server that is currently hosting your site.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Version"><?php esc_html_e( 'PHP Version', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of PHP installed on your hosting server.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php
					// Check if phpversion function exists
					if ( function_exists( 'phpversion' ) ) {
						$php_version = phpversion();
						if (version_compare($php_version,'5.6.0') >= 0) {
							echo '<mark class="yes">' . esc_html( $php_version ) . '</mark>';
						} else if (version_compare($php_version,'5.3.0') >= 0) {
							echo '<div style="color:#0073aa;">' . esc_html( $php_version ) . ' - ' . esc_html__( 'The recommended version is the 5.6.','ttbase-framework' ) . '</div>';
						} else {
							echo '<mark class="error">' . esc_html( $php_version ) . ' - ' . esc_html__( 'You are running an obsolete version of PHP. For your security and a proper functioning of the theme you have to upgrade it a newer version (5.6 is recommended). Please contact your hosting provider.','ttbase-framework' ) . '</mark>';
						}
					} else {
						esc_html_e( "Couldn't determine PHP version because phpversion() doesn't exist.", 'ttbase-framework' );
					}
					?></td>
			</tr>
			<?php if ( function_exists( 'ini_get' ) ) : ?>
				<tr>
					<td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP Post Max Size', 'ttbase-framework' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest filesize that can be contained in one post.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
					<td><?php
					$php_max_size = (int) ini_get('post_max_size');
					if ( $php_max_size < 32 ) {
						echo '<mark class="error">' . sprintf( wp_kses(__( '%s - Recommended value is at least 32. <a href="%s" target="_blank">Please increase it.</a>', 'ttbase-framework' ), array( 'a' => array( 'href' => array(),'target' => array() ) ) ), size_format( ttbbase_framework_let_to_num( ini_get('post_max_size') ) ), 'https://www.a2hosting.com/kb/developer-corner/php/using-php-directives-in-custom-htaccess-files/setting-the-php-maximum-upload-file-size-in-an-htaccess-file' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . size_format( ttbbase_framework_let_to_num( ini_get('post_max_size') ) ) . '</mark>';
					}
					?></td>
				</tr>
				<tr>
					<td data-export-label="PHP Time Limit"><?php esc_html_e( 'PHP Time Limit', 'ttbase-framework' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
					<td><?php
					$php_max_time = ini_get('max_execution_time');
					if ( $php_max_time < 120 ) {
						echo '<mark class="error">' . sprintf( wp_kses(__( '%s - Recommended value is at least 120. <a href="%s" target="_blank">Please increase it.</a>', 'ttbase-framework' ), array( 'a' => array( 'href' => array(),'target' => array() ) ) ), $php_max_time, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . $php_max_time . '</mark>';
					}
					?></td>
				</tr>
				<tr>
				<?php
					$max_input = ini_get('max_input_vars');
					if ( $max_input < 3000 ) {
						$max_input = '<span class="error">' . $max_input . '  -  ' . sprintf( wp_kses(__( 'Recommended value is at least 3000. <a href="%s">Please increase it.</a>', 'ttbase-framework' ), array( 'a' => array( 'href' => array(),'target' => array() ) ) ), 'http://docs.woothemes.com/document/problems-with-large-amounts-of-data-not-saving-variations-rates-etc/#section-2' ) . '</span>';
					} else {
						$max_input = '<mark class="yes">' . $max_input . '</mark>';
					}
				?>
					<td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP Max Input Vars', 'ttbase-framework' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
					<td><?php echo wp_kses_post($max_input); ?></td>
				</tr>
				<tr>
					<td data-export-label="SUHOSIN Installed"><?php esc_html_e( 'SUHOSIN Installed', 'ttbase-framework' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
					<td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
				</tr>
			<?php endif; ?>
			<tr>
				<td data-export-label="MySQL Version"><?php esc_html_e( 'MySQL Version', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of MySQL installed on your hosting server.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td>
					<?php
					/** @global wpdb $wpdb */
					global $wpdb;
					echo esc_html($wpdb->db_version());
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Max Upload Size"><?php esc_html_e( 'Max Upload Size', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest filesize that can be uploaded to your WordPress installation.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php
				$php_max_size = (int) size_format( wp_max_upload_size() );
				if ( $php_max_size < 32 ) {
					echo '<mark class="error">' . sprintf( wp_kses(__( '%s - Recommended value is at least 32. <a href="%s" target="_blank">Please increase it.</a>', 'ttbase-framework' ), array( 'a' => array( 'href' => array(),'target' => array() ) ) ), size_format( wp_max_upload_size() ), 'https://www.a2hosting.com/kb/developer-corner/php/using-php-directives-in-custom-htaccess-files/setting-the-php-maximum-upload-file-size-in-an-htaccess-file' ) . '</mark>';
				} else {
					echo '<mark class="yes">' . size_format( wp_max_upload_size() ) . '</mark>';
				}
				?></td>
			</tr>
			<tr>
				<td data-export-label="Allow URL fopen"><?php esc_html_e( 'Allow URL fopen', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest filesize that can be uploaded to your WordPress installation.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php
				if ( !ini_get('allow_url_fopen') ) {
					echo '<mark class="error">' . sprintf( wp_kses(__( 'Disabled - For the import of the demo data this value needs to be enabled. <a href="%s" target="_blank">Please enabled it.</a>', 'ttbase-framework' ), array( 'a' => array( 'href' => array(),'target' => array() ) ) ), 'https://www.a2hosting.com/kb/developer-corner/php/using-php.ini-directives/php-allow-url-fopen-directive' ) . '</mark>';
				} else {
					echo '<mark class="yes">' . esc_html__('Enabled','ttbase-framework') . '</mark>';
				}
				?></td>
			</tr>
			<tr>
				<td data-export-label="Default Timezone is UTC"><?php esc_html_e( 'Default Timezone is UTC', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The default timezone for your server.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php
					$default_timezone = date_default_timezone_get();
					if ( 'UTC' !== $default_timezone ) {
						echo '<mark class="error">' . '&#10005; ' . sprintf( esc_html__( 'Default timezone is %s - it should be UTC', 'ttbase-framework' ), $default_timezone ) . '</mark>';
					} else {
						echo '<mark class="yes">' . '&#10004;' . '</mark>';
					} ?>
				</td>
			</tr>
		</tbody>
	</table>
	<table class="widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Theme"><?php esc_html_e( 'Theme', 'ttbase-framework' ); ?></th>
			</tr>
		</thead>
			<?php
			$active_theme = wp_get_theme();
			?>
		<tbody>
			<tr>
				<td data-export-label="Name" style="width: 33%;"><?php esc_html_e( 'Name', 'ttbase-framework' ); ?>:</td>
				<td class="help" style="width: 15px;"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The name of the current active theme.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_html($active_theme->Name); ?></td>
			</tr>
			<tr>
				<td data-export-label="Version"><?php esc_html_e( 'Version', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The installed version of the current active theme.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php
					echo esc_html($active_theme->Version);

					if ( ! empty( $theme_version_data['version'] ) && version_compare( $theme_version_data['version'], $active_theme->Version, '!=' ) ) {
						echo ' &ndash; <strong style="color:red;">' . $theme_version_data['version'] . ' ' . esc_html__( 'is available', 'ttbase-framework' ) . '</strong>';
					}
				?></td>
			</tr>
			<tr>
				<td data-export-label="Author URL"><?php esc_html_e( 'Author URL', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The theme developers URL.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo wp_kses_post($active_theme->{'Author URI'}); ?></td>
			</tr>
			<tr>
				<td data-export-label="Child Theme"><?php esc_html_e( 'Child Theme', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Displays whether or not the current theme is a child theme.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php
					echo is_child_theme() ? '<mark class="yes">' . '&#10004;' . '</mark>' : '&#10005; &ndash; ' . sprintf( wp_kses(__( 'If you\'re modifying gymx or a parent theme you didn\'t build personally, we recommend using a child theme. See: <a href="%s" target="_blank">How to create a child theme</a>', 'ttbase-framework' ), array( 'a' => array( 'href' => array(),'target' => array() ) ) ), 'http://codex.wordpress.org/Child_Themes' );
				?></td>
			</tr>
			<?php
			if( is_child_theme() ) :
				$parent_theme = wp_get_theme( $active_theme->Template );
			?>
			<tr>
				<td data-export-label="Parent Theme Name"><?php esc_html_e( 'Parent Theme Name', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The name of the parent theme.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_html($parent_theme->Name); ?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Version"><?php echo esc_html_e( 'Parent Theme Version', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The installed version of the parent theme.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_html($parent_theme->Version); ?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Author URL"><?php esc_html_e( 'Parent Theme Author URL', 'ttbase-framework' ); ?>:</td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The parent theme developers URL.', 'ttbase-framework' ) . '">[?]</a>'; ?></td>
				<td><?php echo wp_kses_post($parent_theme->{'Author URI'}); ?></td>
			</tr>
			<?php endif ?>
		</tbody>
	</table>
	<table class="widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Active Plugins (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)"><?php esc_html_e( 'Active Plugins', 'ttbase-framework' ); ?> (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( is_multisite() ) {
				$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			}

			foreach ( $active_plugins as $plugin ) {

				$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
				$dirname        = dirname( $plugin );
				$version_string = '';
				$network_string = '';

				if ( ! empty( $plugin_data['Name'] ) ) {

					// link the plugin name to the plugin url if available
					$plugin_name = esc_html( $plugin_data['Name'] );

					if ( ! empty( $plugin_data['PluginURI'] ) ) {
						$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_attr__( 'Visit plugin homepage' , 'ttbase-framework' ) . '" target="_blank">' . $plugin_name . '</a>';
					}

					?>
					<tr>
						<td style="width: 33%;"><?php echo wp_kses_post($plugin_name); ?></td>
						<td><?php echo sprintf( esc_html_x( 'by %s', 'by author', 'ttbase-framework' ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; ?></td>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">

	jQuery( document ).ready( function ( $ ) {
		$( '.help_tip' ).tipTip({
			attribute: 'data-tip'
		});

		$( 'a.help_tip' ).click( function() {
			return false;
		});

	});

</script>