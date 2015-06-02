<?php
defined( 'ABSPATH' ) or die( 'Sorry!' );

if ( !is_user_logged_in() )
	wp_die( 'You must be logged in to run this script.' );

if ( !current_user_can( 'install_plugins' ) )
	wp_die( 'You do not have permission to run this script.' );

delete_option('dupContCure_noindex_options');

?>