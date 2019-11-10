<?php
/**
 * Plugin Name: Google Analytics for WordPress
 * Plugin URI: https://wordpress.org/plugins/pc-google-analytics/
 * Description: This Google Analytics for WordPress plugin adds and enables Google Analytics tracking code on your website.
 * Version: 1.1
 * Author: praveenchauhan1984
 * Author URI: http://lifesoftwares.com/
 * Requires at least: 3.0
 * Tested up to: 4.6.1
 *
 * Text Domain: pc-google-analytics
 * Domain Path: /lang/
 * License: GPL2
 */


if ( ! defined( 'ABSPATH' ) ) exit;         

// Load plugin class files
require_once( 'includes/class-pc-google-analytics.php' );
require_once( 'includes/class-pc-google-analytics-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-pc-google-analytics-admin-api.php' );

/**
 * Returns the main instance of Pc_Google_Analytics to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Pc_Google_Analytics
 */
function Pc_Google_Analytics () {
	$instance = Pc_Google_Analytics::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Pc_Google_Analytics_Settings::instance( $instance );
	}

	return $instance;
}

Pc_Google_Analytics();


function pc_google_analytics_front() { 
         $flag=0;
		 $user_ID = get_current_user_id();		 
		 $analytics_id=  get_option( 'pcga_google_analytics_id' );
		
		 $exclude_users=get_option('pcga_exclude_users');
		 $disable_tracking=get_option('pcga_disable_tracking');
		
		
		
		if ( is_user_logged_in() ) { 
			$user = new WP_User( $user_ID );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role )
					 $role;
			}
		}
		
		
		
		
		 
		 if(get_option('pcga_google_analytics_id')==''){
		 	$flag=1; 
		 }
		 else if($disable_tracking=='on'){
		 	$flag=1; 
		 }
		 
		 if(!empty($exclude_users) && is_user_logged_in()){
		 
			 if (in_array('administrator',$exclude_users) && $role=='administrator' ) {
				$flag=1; 
			 }
			 else if (in_array('author',$exclude_users) && $role=='author' ) {
				$flag=1; 
			 }
			 else if (in_array('contributor',$exclude_users) && $role=='contributor' ) {
				$flag=1; 
			 }
			 else if (in_array('editor',$exclude_users) && $role=='editor' ) {
				$flag=1; 
			 }
			 else if (in_array('subscriber',$exclude_users) && $role=='subscriber' ) {
				$flag=1; 
			 }
		 }
		 
	
		 
		 
        if($flag!='1'){ ?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		ga('create', '<?php echo esc_attr( get_option('pcga_google_analytics_id') ); ?>', 'auto');
		ga('send', 'pageview');
		
		</script>
<?php } }  
add_action( 'wp_head', 'pc_google_analytics_front', 10 );