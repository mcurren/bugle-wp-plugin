<?php
	/*
	Plugin Name: Bugle Call To Action
	Plugin URI: http://curren.me
	Description: Create content-specific "call to action" modules that can be included at the bottom of pages in your theme.
	Version: 0.1
	Author: Mike Curren
	Author URI: http://curren.me
	License: GPL2
	*/

add_action( 'init', 'bugle_init', 0 );

/* Register "Call to Action" Custom Post Type */

function bugle_init() {

	$labels = array(
		'name'                => _x( 'Calls To Action', 'Post Type General Name', 'bugle_cta' ),
		'singular_name'       => _x( 'Call To Action', 'Post Type Singular Name', 'bugle_cta' ),
		'menu_name'           => __( 'Calls To Action', 'bugle_cta' ),
		'name_admin_bar'      => __( 'Calls To Action', 'bugle_cta' ),
		'parent_item_colon'   => __( 'Parent CTA:', 'bugle_cta' ),
		'all_items'           => __( 'All CTAs', 'bugle_cta' ),
		'add_new_item'        => __( 'Add New CTA', 'bugle_cta' ),
		'add_new'             => __( 'Add New', 'bugle_cta' ),
		'new_item'            => __( 'New CTA', 'bugle_cta' ),
		'edit_item'           => __( 'Edit CTA', 'bugle_cta' ),
		'update_item'         => __( 'Update CTA', 'bugle_cta' ),
		'view_item'           => __( 'View CTA', 'bugle_cta' ),
		'search_items'        => __( 'Search CTA', 'bugle_cta' ),
		'not_found'           => __( 'Not found', 'bugle_cta' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'bugle_cta' ),
	);
	$args = array(
		'label'               => __( 'Call To Action', 'bugle_cta' ),
		'description'         => __( 'Create content-specific calls to action that can be included after your page content.', 'bugle_cta' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'revisions', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-megaphone',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,		
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
	);
	register_post_type( 'bugle_call_to_action', $args );

}


/* Include ACF custom fields */

include_once 'cta-acf-options.php';
include_once 'cta-acf-fields.php';


/* Add plugin styles */

add_action('init', 'bugle_register_styles');

function bugle_register_styles() {
	wp_register_style('bugle-style', plugins_url('/css/style.css', __FILE__), false, '1.0.0', 'screen');
}

add_action('wp_enqueue_scripts', 'bugle_enqueue_styles');

function bugle_enqueue_styles(){
	wp_enqueue_style('bugle-style');
}

/* Show CTA on pages */

add_action('get_footer', 'bugle_display_cta');

function bugle_display_cta() {
	$default_cta_object = get_field('default_cta_mod', 'option');
	if($default_cta_object) : 

		/* Setup post object */
		$my_cta = $default_cta_object;
		setup_postdata($my_cta);

		/* Setup CTA content */
		$cta_id = $my_cta->ID;
		$cta_headline = get_field('heading', $cta_id);
		$cta_tagline = get_field('sub_heading', $cta_id);
		$cta_button_txt = get_field('button_text', $cta_id);
		$cta_link_type = get_field('link_type', $cta_id);
		if($cta_link_type == 'local') { // "local" link
			$cta_link_url = get_field('select_a_page', $cta_id);
		} else { // "remote" link
			$cta_link_url = get_field('enter_a_url', $cta_id);
		}
		// $cta_ = get_field('', $cta_id);

		/* Create CTA module */
		$cta_markup = '<div class="bugle-box">';
		$cta_markup .= '<div class="bugle-box__inside">';
		$cta_markup .= '<div class="bugle-box__call">';
		$cta_markup .= '<div class="bugle-box__call__head">';
		$cta_markup .= '<h2>' . $cta_headline . '</h2>';
		$cta_markup .= '</div><!-- .bugle-box__call__head -->';
		$cta_markup .= '<div class="bugle-box__call__tag">';
		$cta_markup .= '<h3>' . $cta_tagline . '</h3>';
		$cta_markup .= '</div><!-- .bugle-box__call__tag -->';
		$cta_markup .= '</div><!-- .bugle-box__call -->';
		$cta_markup .= '<div class="bugle-box__action">';
		$cta_markup .= '<a href="' . $cta_link_url . '" class="bugle-box__button">' . $cta_button_txt . '</a>';
		$cta_markup .= '</div><!-- .bugle-box__action -->';
		$cta_markup .= '</div><!-- .bugle-box__inside -->';
		$cta_markup .= '</div><!-- .bugle-box -->';

		/* Show the CTA content */
		echo $cta_markup;

		/* Reset normal post data */
		wp_reset_postdata();

	endif;
}


/**
 * --- Ways to implement ---
 * ## Insert into theme automatically (action/filter hook)
 * ## Insert into theme manually (public function)
 * ## Use as a widget (allow multiple instances)
 */


/**
 * --- Action icon options ---
 * GO | DOWNLOAD | REGISTER | SIGN UP | CONTACT | PURCHASE | 
 */


/**
 * --- Possible theme hooks/filters ---
 * Default: 'the_content' filter -OR- 'get_footer' action
 * Themify: themify_layout_after()
 * 
 */


/**
 * --- Most purchased Themforest themes ---
 * Avada - http://themeforest.net/item/avada-responsive-multipurpose-theme/2833226
 * X - http://themeforest.net/item/x-the-theme/5871901
 * Enfold - http://themeforest.net/item/enfold-responsive-multipurpose-theme/4519990
 * BeTheme - http://themeforest.net/item/betheme-responsive-multipurpose-wordpress-theme/7758048
 */


/* eof */