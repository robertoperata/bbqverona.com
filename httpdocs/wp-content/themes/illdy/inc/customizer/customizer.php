<?php
/**
 *  Customizer
 */
if(!function_exists('illdy_customize_register')) {
    function illdy_customize_register( $wp_customize ) {

        // Get Settings
        $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
        $wp_customize->get_setting( 'header_image'  )->transport = 'postMessage';
        $wp_customize->get_setting( 'header_image_data'  )->transport = 'postMessage';

        // Get Sections
        $wp_customize->get_section( 'header_image' )->title = esc_html__( 'Blog Header Image', 'illdy' );

        /**********************************************/
        /*************** INIT ************************/
        /**********************************************/

        // Custom Controls
        require_once get_template_directory() . '/inc/customizer/custom-controls.php';

        // General Options
        require_once get_template_directory() . '/inc/customizer/panels/general-options.php';

        // Single Post Option
        require_once get_template_directory() . '/inc/customizer/panels/single-post-options.php';

        // Jumbotron
        require_once get_template_directory() . '/inc/customizer/panels/jumbotron.php';

        // About
        require_once get_template_directory() . '/inc/customizer/panels/about.php';

        // Projects
        require_once get_template_directory() . '/inc/customizer/panels/projects.php';

        // Testimonials
        require_once get_template_directory() . '/inc/customizer/panels/testimonials.php';

        // Services
        require_once get_template_directory() . '/inc/customizer/panels/services.php';

        // Latest News
        require_once get_template_directory() . '/inc/customizer/panels/latest-news.php';

        // Counter
        require_once get_template_directory() . '/inc/customizer/panels/counter.php';

        // Team
        require_once get_template_directory() . '/inc/customizer/panels/team.php';

        // Contact Us
        require_once get_template_directory() . '/inc/customizer/panels/contact-us.php';
    }
    add_action( 'customize_register', 'illdy_customize_register');
}

/**
 *  Customizer Live Preview
 */
if(!function_exists('illdy_customizer_live_preview')) {
    add_action( 'customize_preview_init', 'illdy_customizer_live_preview' );
    function illdy_customizer_live_preview() {
        wp_enqueue_script( 'illdy-customizer-live-preview', get_template_directory_uri() . '/inc/customizer/assets/js/illdy-customizer-live-preview.js', array('customize-preview'), '1.0', true);
    }
}

/**
 *  Customizer
 */
if(!function_exists('illdy_customizer')) {
    add_action( 'customize_controls_enqueue_scripts', 'illdy_customizer' );
    function illdy_customizer() {
        wp_enqueue_script( 'illdy-customizer', get_template_directory_uri() . '/inc/customizer/assets/js/customizer.js', array( 'jquery' ), '' /* '20120206' */, true  );
    }
}

/**
 *  Sanitize File URL
 */
if(!function_exists('illdy_sanitize_file_url')) {
    function illdy_sanitize_file_url( $url ) {
        $output = '';

        $filetype = wp_check_filetype($url);
        if ($filetype["ext"]) {
            $output = esc_url($url);
        }

        return $output;
    }
}

/**
 *  Sanitize Radio Buttons
 */
if(!function_exists('illdy_sanitize_radio_buttons')) {
    function illdy_sanitize_radio_buttons( $input, $setting ) {
        global $wp_customize;

        $control = $wp_customize->get_control( $setting->id );

        if ( array_key_exists( $input, $control->choices ) ) {
            return $input;
        } else {
            return $setting->default;
        }
    }
}

/**
 *  Customizer CSS
 */
if( !function_exists( 'illdy_customizer_css' ) ) {
    add_action( 'wp_head', 'illdy_customizer_css' );
    function illdy_customizer_css() {
        $preloader_primary_color = get_theme_mod( 'illdy_preloader_primary_color', '#f1d204' );
        $preloader_secondly_color = get_theme_mod( 'illdy_preloader_secondly_color', '#ffffff' );
        $preloader_background_color = get_theme_mod( 'illdy_preloader_background_color', '#ffffff' );

        $output = '';

        $output .= '<style type="text/css">';
            $output .= ( $preloader_primary_color ? '.pace .pace-progress {background-color: '. $preloader_primary_color .'; color: '. $preloader_primary_color .';}' : '' );
            $output .= ( $preloader_primary_color || $preloader_secondly_color ? '.pace .pace-activity {box-shadow: inset 0 0 0 2px '. $preloader_primary_color .', inset 0 0 0 7px '. $preloader_secondly_color .';}' : '' );
            $output .= ( $preloader_background_color ? '.pace-overlay {background-color: '. $preloader_background_color .';}' : '' );
        $output .= '</style>';

        echo $output;
    }
}

if( !function_exists( 'illdy_sanitize_checkbox' ) ) {
    /**
     * Function to sanitize checkboxes
     *
     * @param $value
     * @return int
     */
    function illdy_sanitize_checkbox($value)
    {
        if ($value == 1) {
            return 1;
        } else {
            return 0;
        }
    }
}

/**
 *  Active Callback: Is active JetPack Testimonials
 */
if( !function_exists( 'is_active_jetpack_testimonials' ) ) {
    function is_active_jetpack_testimonials() {
        if( post_type_exists( 'jetpack-testimonial' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 *  Active Callback: Is not active JetPack Testimonials
 */
if( !function_exists( 'is_not_active_jetpack_testimonials' ) ) {
    function is_not_active_jetpack_testimonials() {
        if( !post_type_exists( 'jetpack-testimonial' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 *  Active Callback: Is not active Contact Form 7
 */
if( !function_exists( 'is_not_active_contact_form_7' ) ) {
    function is_not_active_contact_form_7() {
        if( !class_exists( 'WPCF7' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 *  Sanitize HTML
 */
if( !function_exists( 'illdy_sanitize_html' ) ) {
    function illdy_sanitize_html( $input ) {
        $input = force_balance_tags( $input ); // Force HTML tags to be properly closed
        
        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'img' => array(
                'alt' => array(),
                'src' => array(),
                'srcset' => array(),
                'title' => array()
            ),
            'strong' => array(),
        );
        $output = wp_kses( $input, $allowed_html ); // Apply HTML filter to output
        return $output;
    }
}