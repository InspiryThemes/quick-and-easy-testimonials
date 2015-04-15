<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://saqibsarwar.com/
 * @since      1.0.0
 *
 * @package    Quick_And_Easy_Testimonials
 * @subpackage Quick_And_Easy_Testimonials/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Quick_And_Easy_Testimonials
 * @subpackage Quick_And_Easy_Testimonials/admin
 * @author     M Saqib Sarwar <saqibsarwar@gmail.com>
 */
class Quick_And_Easy_Testimonials_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quick_And_Easy_Testimonials_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quick_And_Easy_Testimonials_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quick-and-easy-testimonials-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quick_And_Easy_Testimonials_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quick_And_Easy_Testimonials_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quick-and-easy-testimonials-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register Testimonials custom post type
     *
     * @since     1.0.0
     */
    public function register_testimonials_post_type() {

        $labels = array(
            'name'                => _x( 'Testimonials', 'Post Type General Name', 'qe-testimonials' ),
            'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'qe-testimonials' ),
            'menu_name'           => __( 'Testimonials', 'qe-testimonials' ),
            'name_admin_bar'      => __( 'Testimonials', 'qe-testimonials' ),
            'parent_item_colon'   => __( 'Parent Testimonial:', 'qe-testimonials' ),
            'all_items'           => __( 'All Testimonials', 'qe-testimonials' ),
            'add_new_item'        => __( 'Add New Testimonial', 'qe-testimonials' ),
            'add_new'             => __( 'Add New', 'qe-testimonials' ),
            'new_item'            => __( 'New Testimonial', 'qe-testimonials' ),
            'edit_item'           => __( 'Edit Testimonial', 'qe-testimonials' ),
            'update_item'         => __( 'Update Testimonial', 'qe-testimonials' ),
            'view_item'           => __( 'View Testimonial', 'qe-testimonials' ),
            'search_items'        => __( 'Search Testimonial', 'qe-testimonials' ),
            'not_found'           => __( 'Not found', 'qe-testimonials' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'qe-testimonials' ),
        );

        $args = array(
            'label'               => __( 'testimonial', 'qe-testimonials' ),
            'description'         => __( 'Client testimonials', 'qe-testimonials' ),
            'labels'              => apply_filters( 'qe_testimonials_labels', $labels),
            'supports'            => apply_filters( 'qe_testimonial_supports', array( 'title', 'editor', 'thumbnail' ) ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 10,
            'menu_icon'           => 'dashicons-format-quote',
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );

        register_post_type( 'testimonial', apply_filters( 'qe_register_testimonial_arguments', $args) );

    }

    /**
     * Register Testimonial Category custom taxonomy
     *
     * @since     1.0.0
     */
    public function register_testimonials_category_taxonomy() {

        $labels = array(
            'name'                       => _x( 'Testimonial Categories', 'Taxonomy General Name', 'qe-testimonials' ),
            'singular_name'              => _x( 'Testimonial Category', 'Taxonomy Singular Name', 'qe-testimonials' ),
            'menu_name'                  => __( 'Testimonial Category', 'qe-testimonials' ),
            'all_items'                  => __( 'All Testimonial Categories', 'qe-testimonials' ),
            'parent_item'                => __( 'Parent Testimonial Category', 'qe-testimonials' ),
            'parent_item_colon'          => __( 'Parent Testimonial Category:', 'qe-testimonials' ),
            'new_item_name'              => __( 'New Testimonial Category Name', 'qe-testimonials' ),
            'add_new_item'               => __( 'Add New Testimonial Category', 'qe-testimonials' ),
            'edit_item'                  => __( 'Edit Testimonial Category', 'qe-testimonials' ),
            'update_item'                => __( 'Update Testimonial Category', 'qe-testimonials' ),
            'view_item'                  => __( 'View Testimonial Category', 'qe-testimonials' ),
            'separate_items_with_commas' => __( 'Separate Testimonial Categories with commas', 'qe-testimonials' ),
            'add_or_remove_items'        => __( 'Add or remove Testimonial Categories', 'qe-testimonials' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'qe-testimonials' ),
            'popular_items'              => __( 'Popular Testimonial Categories', 'qe-testimonials' ),
            'search_items'               => __( 'Search Testimonial Categories', 'qe-testimonials' ),
            'not_found'                  => __( 'Not Found', 'qe-testimonials' ),
        );

        $args = array(
            'labels'                     => apply_filters( 'qe_testimonial_category_labels', $labels ),
            'hierarchical'               => true,
            'public'                     => false,
            'rewrite'                    => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
        );

        register_taxonomy( 'testimonial-category', array( 'testimonial' ), apply_filters( 'qe_register_testimonial_category_arguments', $args ) );

    }
}
