<?php 

if( function_exists('acf_add_options_page') ):

	$page = acf_add_options_page(array(
		'page_title' 	=> 'Call To Action Settings',
		'menu_title' 	=> 'CTA Settings',
		'menu_slug' 	=> 'cta-settings',
		'capability' 	=> 'edit_pages',
		'redirect' 	=> true,
		'autoload' => true,
	));

endif;

/* eof */