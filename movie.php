<?php
/*
Plugin Name: Movie

*/


$plugin = new MoviePlugin;

if(!defined("PLUGIN_DIR")) {
    define('PLUGIN_DIR',plugin_dir_path(__FILE__));
}


#load classes
require_once __DIR__ . '/custom_fields.php';

class MoviePlugin {

    public function __construct() {
        // Register Post Type
        add_action('init', array($this,'registermovie'));
        add_filter( 'template_include',array($this, 'include_template_function') );
		add_action( 'wp_enqueue_scripts',array($this,'blog_scripts') );
       
      add_action('wp_ajax_load_posts_by_ajax', array($this,'load_posts_by_ajax_callback'));
      add_action('wp_ajax_nopriv_load_posts_by_ajax',array($this, 'load_posts_by_ajax_callback'));
        
      }
	 
  	 public function registermovie() {
        register_post_type('movie', array(
            'labels' => array(
                'name' => __('movie'),
                'singular_name' => __('movie')
            ),
            'menu_icon' => 'dashicons-star-filled',
            'public' => true,
            'publicly_queryable' => true,
            'rewrite' => false,
            'has_archive' => true,
            'rewrite' => array(
                'slug' => 'movie',
                'with_front' => true
            ),
            'supports' => array('title','editor','thumbnail','excerpt'),
        ));
		
		
    }

	function blog_scripts() {
    // Register the script
    wp_register_script( 'custom-script',  plugins_url().'/movie/js/custom.js', array('jquery'), false, true );
	
    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'load_more_posts' ),
    );
    wp_localize_script( 'custom-script', 'movie', $script_data_array );
  
    // Enqueued script with localized data.
    wp_enqueue_script( 'custom-script' );
 }


	function include_template_function( $template_path ) {
    
	if ( get_post_type() == 'movie' ) {
 		if ( is_single() ) {
 			// checks if the file exists in the theme first,
 			// otherwise serve the file from the plugin
 			if ( $theme_file = locate_template( array ( 'single_movie.php' ) ) ) {
 				$template_path = $theme_file;
 			} else {
 				$template_path = plugin_dir_path( __FILE__ ) . '/single_movie.php';
 			}
 		}
		else
		{
			if ( $theme_file = locate_template( array ( 'page-movie.php' ) ) ) {
 				$template_path = $theme_file;
 			} else {
 				$template_path = plugin_dir_path( __FILE__ ) . '/page-movie.php';
 			}
			
		}
 	}
 	return $template_path;
   }
   
   
   function load_posts_by_ajax_callback() {
    check_ajax_referer('load_more_posts', 'security');
    $args = array(
        'post_type' => 'movie',
        'post_status' => 'publish',
        'posts_per_page' => '2',
        'paged' => $_POST['page'],
    );
    $blog_posts = new WP_Query( $args );
    ?>
  
    <?php if ( $blog_posts->have_posts() ) : ?>
        <?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    <?php
    wp_die();
   }
}
?>
