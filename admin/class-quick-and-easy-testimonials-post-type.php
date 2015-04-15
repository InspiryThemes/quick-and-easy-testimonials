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
 * Testimonial custom post type class
 *
 * @package    Quick_And_Easy_Testimonials
 * @subpackage Quick_And_Easy_Testimonials/admin
 * @author     M Saqib Sarwar <saqibsarwar@gmail.com>
 */
class Quick_And_Easy_Testimonials_Post_Type {
    public $post_type_name;

    /**
     * public constructor function.
     *
     * @since   1.0.0
     */
    public function __construct() {
        $this->post_type_name = 'testimonial';
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

        register_post_type( $this->post_type_name, apply_filters( 'qe_register_testimonial_arguments', $args) );

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

        register_taxonomy( 'testimonial-category', array( $this->post_type_name ), apply_filters( 'qe_register_testimonial_category_arguments', $args ) );

    }

    /**
     * Add custom column headings for testimonial image
     *
     * @param   array   $defaults
     * @since   1.0.0
     * @return  array   $defaults
     */
    public function register_custom_column_headings ( $defaults ) {
        $new_columns = array( 'image' => __( 'Image', 'qe-testimonials' ) );

        $last_items = array();

        if ( count( $defaults ) > 2 ) {
            $last_items = array_slice( $defaults, -1 );
            array_pop( $defaults );
        }

        $defaults = array_merge( $defaults, $new_columns );
        $defaults = array_merge( $defaults, $last_items );

        return $defaults;
    }

    /**
     * Register custom column for image.
     *
     * @access  public
     * @param   string $column_name
     * @since   1.0.0
     * @return  void
     */
    public function register_custom_column ( $column_name ) {
        global $post;

        switch ( $column_name ) {

            case 'image':
                $value = $this->get_image( $post->ID, 'thumbnail' );
                echo $value;
                break;

            default:
                break;
        }
    }

    /**
     * Get the featured image for the given testimonial id. If no featured image, check for Gravatar based on email
     * @param  int 				$id   Testimonial ID ( Post ID ).
     * @param  string/array/int $size Image dimension.
     * @since  1.0.0
     * @return string       	html image tag
     */
    public static function get_image ( $id, $size ) {
        $response = '';

        if ( has_post_thumbnail( $id ) ) {

            // If not a string or an array, and not an integer, default to 150x9999.
            if ( ( is_int( $size ) || ( 0 < intval( $size ) ) ) && ! is_array( $size ) ) {
                $size = array( intval( $size ), intval( $size ) );
            } elseif ( ! is_string( $size ) && ! is_array( $size ) ) {
                $size = array( 50, 50 );
            }
            $response = get_the_post_thumbnail( intval( $id ), $size, array( 'class' => 'avatar' ) );

        } else {

            $gravatar_email = get_post_meta( $id, '_gravatar_email', true );
            $gravatar_email = is_email( $gravatar_email );

            if ( $gravatar_email  ) {

                if ( ( is_int( $size ) || ( 0 < intval( $size ) ) ) && ! is_array( $size ) ) {
                    $size = intval( $size );
                } elseif ( ! is_string( $size ) && ! is_array( $size ) ) {
                    $size = 50;
                } elseif( is_string( $size ) ) {
                    global $_wp_additional_image_sizes;
                    if ( in_array( $size , array( 'thumbnail', 'medium', 'large' ) ) ) {
                        $size = intval( get_option( $size . '_size_w' ) );
                    } elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
                        $size = intval( $_wp_additional_image_sizes[ $size ]['width'] );
                    }
                } elseif ( is_array( $size ) ) {
                    $size = intval( $size[0] );
                }

                $response = get_avatar( $gravatar_email, $size );

            }

        }

        return $response;
    }


    /**
     * Add meta box to collect testimonial meta information
     *
     * @access public
     * @since  1.0.0
     * @return void
     */
    public function add_testimonial_meta_box () {
        add_meta_box( 'testimonial-data', __( 'Testimonial Details', 'qe-testimonials' ), array( $this, 'generate_meta_box' ), $this->post_type_name, 'normal', 'high' );
    }

    /**
     * Generate meta box markup on admin side
     *
     * @access public
     * @since  1.0.0
     * @return void
     */
    public function generate_meta_box () {
        global $post_id;
        $fields = get_post_custom( $post_id );
        $field_data = $this->get_testimonial_fields_settings();

        $html = '';

        $html .= '<input type="hidden" name="qe_' . $this->post_type_name . '_nonce" id="qe_' . $this->post_type_name . '_nonce" value="' . wp_create_nonce( QE_TESTIMONIALS_BASE ) . '" />';

        if ( 0 < count( $field_data ) ) {
            $html .= '<table class="form-table">' . "\n";
            $html .= '<tbody>' . "\n";

            foreach ( $field_data as $k => $v ) {
                $data = $v['default'];
                if ( isset( $fields['_' . $k] ) && isset( $fields['_' . $k][0] ) ) {
                    $data = $fields['_' . $k][0];
                }

                $html .= '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . $v['name'] . '</label></th><td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
                $html .= '<p class="description">' . $v['description'] . '</p>' . "\n";
                $html .= '</td><tr/>' . "\n";
            }

            $html .= '</tbody>' . "\n";
            $html .= '</table>' . "\n";
        }

        echo $html;
    }

    /**
     * Save testimonial meta box
     *
     * @access public
     * @since  1.0.0
     * @param int $post_id
     * @return int/void
     */
    public function save_testimonial_meta_box ( $post_id ) {

        // Verify
        if ( ( get_post_type() != $this->post_type_name ) || ! wp_verify_nonce( $_POST['qe_' . $this->post_type_name . '_nonce'], QE_TESTIMONIALS_BASE ) ) {
            return $post_id;
        }

        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        $field_data = $this->get_testimonial_fields_settings();
        $field_keys = array_keys( $field_data );

        foreach ( $field_keys as $f ) {

            ${$f} = strip_tags( trim( $_POST[$f] ) );

            // Escape the URLs.
            if ( 'url' == $field_data[$f]['type'] ) {
                ${$f} = esc_url( ${$f} );
            }

            // update database
            if ( get_post_meta( $post_id, '_' . $f ) == '' ) {
                // add
                add_post_meta( $post_id, '_' . $f, ${$f}, true );
            } else if( ${$f} != get_post_meta( $post_id, '_' . $f, true ) ) {
                // update
                update_post_meta( $post_id, '_' . $f, ${$f} );
            } else if ( ${$f} == '' ) {
                // delete
                delete_post_meta( $post_id, '_' . $f, get_post_meta( $post_id, '_' . $f, true ) );
            }
        }
    }

    /**
     * Get the settings for testimonial custom fields.
     * @since  1.0.0
     * @return array
     */
    public function get_testimonial_fields_settings () {
        $fields = array();

        $fields['gravatar_email'] = array(
            'name' => __( 'Email for Gravatar', 'qe-testimonials' ),
            'description' => sprintf( __( 'Provide an email address to use a %sGravatar%s, in case of no featured image.', 'qe-testimonials' ), '<a href="' . esc_url( 'http://gravatar.com/' ) . '" target="_blank">', '</a>' ),
            'type' => 'text',
            'default' => '',
            'section' => 'info'
        );

        $fields['byline'] = array(
            'name' => __( 'Byline', 'qe-testimonials' ),
            'description' => __( 'Provide a byline for the customer giving this testimonial (for example: "CEO of ABC Company").', 'qe-testimonials' ),
            'type' => 'text',
            'default' => '',
            'section' => 'info'
        );

        $fields['url'] = array(
            'name' => __( 'Website URL', 'qe-testimonials' ),
            'description' => __( 'Provide a URL related to this customer (for example: http://companyname.com/ ).', 'qe-testimonials' ),
            'type' => 'url',
            'default' => '',
            'section' => 'info'
        );

        return $fields;
    }

}