<?php
/**
 * Plugin Name:       Quick and Easy Testimonials
 * Plugin URI:        https://wordpress.org/plugins/quick-and-easy-testimonials/
 * Description:       This plugin provides a quick and easy way to add testimonials to your site.
 * Version:           1.1.2
 * Tested up to:      6.6.0
 * Requires PHP:      5.6
 * Author:            InspiryThemes
 * Author URI:        https://inspirythemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       qe-testimonials
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'QE_TESTIMONIALS_BASE', plugin_basename( __FILE__ ) );


if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

define( 'QE_TESTIMONIALS_VERSION', get_plugin_data( __FILE__ )['Version'] );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quick-and-easy-testimonials-activator.php
 */
function activate_quick_and_easy_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-testimonials-activator.php';
	Quick_And_Easy_Testimonials_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quick-and-easy-testimonials-deactivator.php
 */
function deactivate_quick_and_easy_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-testimonials-deactivator.php';
	Quick_And_Easy_Testimonials_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_quick_and_easy_testimonials' );
register_deactivation_hook( __FILE__, 'deactivate_quick_and_easy_testimonials' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-testimonials.php';


/**
 * Display testimonials in a list programmatically
 *
 * @since   1.0.7
 *
 * @param array $attributes Array of attributes
 *
 * @return  string  generated html
 */
function qet_display_testimonials_list( $count = -1, $filter = null, $id = null ) {

	$filter_array = array();

	// testimonials category filter
	if ( ! empty( $filter ) ) {
		$filter_array = explode( ',', $filter );
	}

	wp_enqueue_style( 'quick-and-easy-testimonials', plugin_dir_url( __FILE__ ) . 'public/css/quick-and-easy-testimonials-public.css', array(), '1.0.6', 'all' );


	ob_start();

	// basic query
	$testimonials_query_args = array(
		'post_type'      => 'testimonial',
		'posts_per_page' => $count,
	);

	// modify query based on id attribute
	if ( ! empty( $id ) && 0 < intval( $id ) ) {
		$testimonials_query_args['p'] = intval( $id );
	}

	// modify query based on filter attribute
	if ( ! empty( $filter_array ) ) {
		$testimonials_query_args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial-category',
				'field'    => 'slug',
				'terms'    => $filter_array,
			),
		);
	}

	$testimonials_query = new WP_Query( $testimonials_query_args );

	// Testimonials Loop
	if ( $testimonials_query->have_posts() ) :
		while ( $testimonials_query->have_posts() ) :
			$testimonials_query->the_post();

			$custom_fields_data = get_post_custom();

			$testimonial_email  = '';
			$testimonial_byline = '';
			$testimonial_url    = '';

			if ( isset( $custom_fields_data['_gravatar_email'] ) ) {
				$testimonial_email = $custom_fields_data['_gravatar_email'][0];
			}

			if ( isset( $custom_fields_data['_byline'] ) ) {
				$testimonial_byline = $custom_fields_data['_byline'][0];
			}

			if ( isset( $custom_fields_data['_url'] ) ) {
				$testimonial_url = $custom_fields_data['_url'][0];
			}

			?>
            <div id="qe-testimonial-<?php the_ID(); ?>" class="qe-testimonial-wrapper">

                <div class="qe-testimonial-meta">

					<?php
					$testimonial_email = is_email( $testimonial_email );
					if ( $testimonial_email || has_post_thumbnail( get_the_ID() ) ) {
						echo '<div class="qe-testimonial-img">';
						echo empty( $testimonial_url ) ? '' : '<a href="' . $testimonial_url . '" target="_blank">';
						echo Quick_And_Easy_Testimonials_Post_Type::get_image( get_the_ID(), 'thumbnail' );
						echo empty( $testimonial_url ) ? '' : '</a>';
						echo '</div>';
					}
					?>

                    <cite class="qe-testimonial-author">
                        <span class="qe-testimonial-name"><?php the_title(); ?></span>
						<?php
						if ( ! empty( $testimonial_byline ) ) {
							?>
                            <span class="qe-testimonial-byline">
								<?php
								echo empty( $testimonial_url ) ? '' : '<a href="' . $testimonial_url . '" target="_blank">';
								echo $testimonial_byline;
								echo empty( $testimonial_url ) ? '' : '</a>';
								?>
								</span><!-- /.qe-testimonial-byline -->
							<?php
						}
						?>
                    </cite><!-- /.qe-testimonial-author -->

                </div><!-- /.qe-testimonial-meta -->

                <blockquote class="qe-testimonial-text">
					<?php the_content(); ?>
                </blockquote><!-- /.qe-testimonial-text -->

            </div><!-- /.qe-testimonial-wrapper -->
		<?php
		endwhile;
	endif;

	// custom loops ends here so reset the query
	wp_reset_postdata();

	return ob_get_clean();

}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Quick_And_Easy_Testimonials();
	$plugin->run();

}

run_plugin_name();
