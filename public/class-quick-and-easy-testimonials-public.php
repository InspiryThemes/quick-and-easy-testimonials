<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://saqibsarwar.com/
 * @since      1.0.0
 *
 * @package    Quick_And_Easy_Testimonials
 * @subpackage Quick_And_Easy_Testimonials/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Quick_And_Easy_Testimonials
 * @subpackage Quick_And_Easy_Testimonials/public
 * @author     M Saqib Sarwar <saqibsarwar@gmail.com>
 */
class Quick_And_Easy_Testimonials_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quick-and-easy-testimonials-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        // not needed for now
		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quick-and-easy-testimonials-public.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register testimonials shortcodes
     *
     * @since   1.0.0
     */
    public function register_testimonials_shortcodes() {
        add_shortcode( 'testimonials', array( $this, 'display_testimonials_list') );
    }

    /**
     * Display testimonials in a list
     *
     * @since   1.0.0
     * @param   array   $attributes     Array of attributes
     * @return  string  generated html by shortcode
     */
    public function display_testimonials_list( $attributes ) {

        extract( shortcode_atts( array(
            'count' => -1,
            'filter' => null,
            'id' => null,
        ), $attributes ) );

        $filter_array = array();

        // testimonials category filter
        if ( ! empty ( $filter ) ) {
            $filter_array = explode( ',', $filter );
        }

        ob_start();

        // basic query
        $testimonials_query_args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => $count,
        );

        // modify query based on id attribute
        if ( ! empty ( $id ) && 0 < intval( $id ) ) {
            $testimonials_query_args['p'] = intval( $id );
        }

        // modify query based on filter attribute
        if ( ! empty ( $filter_array ) ) {
            $testimonials_query_args['tax_query'] = array(
                array (
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

                $testimonial_email = '';
                $testimonial_byline = '';
                $testimonial_url = '';

                if ( isset (  $custom_fields_data['_gravatar_email'] ) ) {
                    $testimonial_email = $custom_fields_data['_gravatar_email'][0];
                }

                if ( isset (  $custom_fields_data['_byline'] ) ) {
                    $testimonial_byline = $custom_fields_data['_byline'][0];
                }

                if ( isset (  $custom_fields_data['_url'] ) ) {
                    $testimonial_url = $custom_fields_data['_url'][0];
                }

                ?>
                <div id="qe-testimonial-<?php the_ID(); ?>" class="qe-testimonial-wrapper" itemprop="review" itemscope itemtype="http://schema.org/Review">

                    <div class="qe-testimonial-meta">

                        <?php
                        $testimonial_email = is_email( $testimonial_email );
                        if ( $testimonial_email || has_post_thumbnail( get_the_ID() ) ) {
                            echo '<div class="qe-testimonial-img">';
                            echo empty ( $testimonial_url ) ? '' : '<a href="' . $testimonial_url . '" target="_blank">' ;
                            echo Quick_And_Easy_Testimonials_Post_Type::get_image( get_the_ID(), 'thumbnail' );
                            echo empty ( $testimonial_url ) ? '' : '</a>' ;
                            echo '</div>';
                        }
                        ?>

                        <cite class="qe-testimonial-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
                            <span class="qe-testimonial-name" itemprop="name"><?php the_title(); ?></span>
                            <?php
                            if ( ! empty ( $testimonial_byline ) ) {
                                ?>
                                <span class="qe-testimonial-byline" itemprop="jobTitle">
                                <?php
                                echo empty ( $testimonial_url ) ? '' : '<a href="' . $testimonial_url . '" target="_blank">' ;
                                echo $testimonial_byline;
                                echo empty ( $testimonial_url ) ? '' : '</a>' ;
                                ?>
                                </span><!-- /.qe-testimonial-byline -->
                                <?php
                            }
                            ?>
                        </cite><!-- /.qe-testimonial-author -->

                    </div><!-- /.qe-testimonial-meta -->

                    <blockquote class="qe-testimonial-text" itemprop="reviewBody">
                        <?php the_content(); ?>
                    </blockquote><!-- /.qe-testimonial-text -->

                </div><!-- /.qe-testimonial-wrapper -->
                <?php
            endwhile;
        endif;

        // custom loops ends here so reset the query
        wp_reset_query();

        return ob_get_clean();

    }

}
