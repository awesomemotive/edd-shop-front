<?php
/**
 * Add support for Theme Options in the Customizer
 */


/**		
 * Add 'Customize' link to admin menu under 'Appearance'
 * @since 1.0  
*/

function shopfront_add_customize() {
	add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}
add_action ('admin_menu', 'shopfront_add_customize');

/**		
 * Add some basic styling for extra field descriptions
 * @since 1.0 
*/
function shopfront_style_customize() { ?>
	<style>
		.customize-control-extra {
			color: #999999;
			display:block;
		}

		label + .customize-control-extra {	
			margin-top: 4px;
		}

		span + .customize-control-extra {
			margin-bottom: 4px;
		}

		textarea {
			width: 98%;
		}
	</style>
<?php }
add_action('customize_controls_print_styles', 'shopfront_style_customize');

/**        
 * Create typography array for theme customizer
 * @since 1.0.1 
*/
function shopfront_get_typography_css_files( $directory_path, $filetype, $directory_uri ) {

        $typography = array();

        $files = array();

        if ( is_dir( $directory_path ) ) {
            $files = glob( $directory_path . "*.$filetype");
            
            foreach ( $files as $file ) { 
                $file = str_replace( $directory_path, "", $file);
                $file_label = ucwords(str_replace( array('.css','-'), ' ', $file) );
                $typography[ $file ] = $file_label;
            }
        }
        
        return $typography;
    }    

/**
 * $wp_customize
 *
 * @since 1.0
*/
function shopfront_customize_register( $wp_customize ) {

	/**		
	 * Remove controls
	*/
	$wp_customize->remove_control( 'blogdescription' );
	$wp_customize->remove_control( 'background_color' );


	/**		
	 * Custom controls
	*/
	if ( ! class_exists( 'ShopFront_Custom_Textarea_Control' ) ) :
	class ShopFront_Custom_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() { ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	<?php }
	}
	endif;


	if ( ! class_exists( 'ShopFront_Custom_Text_Control' ) ) :
	// custom text control with 'extra' section
    class ShopFront_Custom_Text_Control extends WP_Customize_Control {
        public $type = 'customtext';
        public $extra = ''; // we add this for the extra description
        public function render_content() {
        ?>
        <label> 
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            
            <input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
        </label>
        <span class="customize-control-extra"><?php echo esc_html( $this->extra ); ?></span>
        <?php
        }
    }
	endif;


	if ( ! class_exists( 'ShopFront_Custom_Image_Control' ) ) :
	class ShopFront_Custom_Image_Control extends WP_Customize_Image_Control {
		/**
		* Constructor.
		*
		* @since 3.4.0
		* @uses WP_Customize_Image_Control::__construct()
		*
		* @param WP_Customize_Manager $manager
		*/
		public function __construct( $manager, $id, $args = array() ) {
		
		parent::__construct( $manager, $id, $args );
		       
		}
		
		/**
		* Search for images within the defined context
		* If there's no context, it'll bring all images from the library
		* 
		*/
		public function tab_uploaded() {
		$my_context_uploads = get_posts( array(
		    'post_type'  => 'attachment',
		    'meta_key'   => '_wp_attachment_context',
		    'meta_value' => $this->context,
		    'orderby'    => 'post_date',
		    'nopaging'   => true,
		) );
		
		?>
		
		<div class="uploaded-target"></div>
		
		<?php
		if ( empty( $my_context_uploads ) )
		    return;
		
		foreach ( (array) $my_context_uploads as $my_context_upload )
		    $this->print_tab_image( esc_url_raw( $my_context_upload->guid ) );
		}
		
	}
	endif;  	


	/**		
	 * Sections
	*/

	// homepage
	$wp_customize->add_section( 'shopfront_section_homepage', array(
		'title'		=> __( 'Homepage', 'shop-front' ),
		'priority'	=> 25,
		'description' => 'Homepage',
	));

	// shop
	

	$wp_customize->add_section( 'shopfront_section_shop', array(
		'title'		=> __( 'Shop', 'shop-front' ),
		'priority'	=> 27,
		'description' => 'Shop',
	));



	// general
	$wp_customize->add_section( 'shopfront_section_general', array(
		'title'		=> __( 'General', 'shop-front' ),
		'priority'	=> 30,
		'description' => 'General',
	));

	// basic styling
	$wp_customize->add_section( 'shopfront_section_styling', array(
		'title'		=> __( 'Styling', 'shop-front' ),
		'priority'	=> 30,
		'description' => 'Styling',
	));



	// footer
	$wp_customize->add_section( 'shopfront_section_footer', array(
		'title'		=> __( 'Footer', 'shop-front' ),
		'priority'	=> 100,
		'description' => 'Footer',
	));




	// blog
	$wp_customize->add_section( 'shopfront_section_blog', array(
		'title'		=> __( 'Blog Page Template', 'shop-front' ),
		'priority'	=> 50,
		'description' => 'Blog',
	));

	// typography. This appears when there is more than 1 stylesheet in the 'typography' folder
	$wp_customize->add_section( 'shopfront_section_typography', array(
		'title'		=> __( 'Typography', 'shop-front' ),
		'priority'	=> 200,
		'description' => 'Typography',
	));

	/**		
	 * Settings and controls
	*/



    /**		
     * Copyright
    */
	$wp_customize->add_setting( 'copyright', array(
		'default' => '',
		'sanitize_callback' => 'shopfront_sanitize_text_field',
		'transport'		 => 'postMessage',
	));

		
	$wp_customize->add_control( new ShopFront_Custom_Text_Control( $wp_customize, 'copyright', array(
	    'label' => __( 'Copyright', 'shop-front' ),
	    'section' => 'shopfront_section_footer',
	    'settings' => 'copyright',
	    ) ) 
	);


	
	// only load these controls if EDD plugin is active
	if( shopfront_edd_is_active() ) {

		/**		
		 * Featured Downloads
		*/

		if( function_exists( 'edd_fd_show_featured_downloads' ) ) {
			
			$wp_customize->add_setting( 'home_featured_downloads', array(
				'default' => '3',
				'sanitize_callback' => 'shopfront_sanitize_round_to_whole_number',
			));

			$wp_customize->add_control( new ShopFront_Custom_Text_Control( $wp_customize, 'home_featured_downloads', array(
			    'label' => __( 'Featured Downloads To Show', 'shop-front' ),
			    'section' => 'shopfront_section_homepage',
			    'extra' => __( '-1 shows all downloads. Enter 0 to disable.', 'shop-front' ),
			    ) ) 
			);
		}

		/**		
		 * Home Latest Downloads
		*/
		$wp_customize->add_setting( 'home_latest_downloads', array(
			'default' => '3',
			'sanitize_callback' => 'shopfront_sanitize_round_to_whole_number',
		));

		$wp_customize->add_control( new ShopFront_Custom_Text_Control( $wp_customize, 'home_latest_downloads', array(
		    'label' => __( 'Latest Downloads To Show', 'shop-front' ),
		    'section' => 'shopfront_section_homepage',
		    'extra' => __( 'Leave blank to show all. Enter 0 to disable.', 'shop-front' ),
		    ) ) 
		);

		/**		
		 * Home Download Columns
		*/
		$wp_customize->add_setting( 'home_download_columns', array(
			'default' => '3',
			'sanitize_callback' => 'shopfront_sanitize_download_columns',
		));

		$wp_customize->add_control( 'home_download_columns', array(
			'label' => __( 'Download Columns', 'shop-front' ),
			'section' => 'shopfront_section_homepage',
			'type'    => 'select',
			'choices' => array(
				'1' => __( '1', 'shop-front' ),
				'2' => __( '2', 'shop-front' ),
				'3' => __( '3', 'shop-front' ),
				'4'	=> __( '4', 'shop-front' ),
			),
		));

		/**		
		 * Home Button Text
		*/


		$wp_customize->add_setting( 'home_button_text', array(
			'default' => __( 'View all', 'shop-front' ),
			'sanitize_callback' => 'shopfront_sanitize_text_field',
		));

		$wp_customize->add_control( new ShopFront_Custom_Text_Control( $wp_customize, 'home_button_text', array(
		    'label' => __( 'Button Text', 'shop-front' ),
		    'section' => 'shopfront_section_homepage',
		    'extra' => __( 'Leave blank to disable.', 'shop-front' ),
		    ) ) 
		);

		/**		
		 * shop title
		*/


		$wp_customize->add_setting( 'post_type_archive_title', array(
			'default' => edd_get_label_plural(),
			'sanitize_callback' => 'shopfront_sanitize_text_field',
		));

		$wp_customize->add_control( new ShopFront_Custom_Text_Control( $wp_customize, 'post_type_archive_title', array(
		    'label' => __( 'Shop Title', 'shop-front' ),
		    'section' => 'shopfront_section_shop',
		    'extra' => __( 'Leave blank to disable', 'shop-front' ),
		    ) ) 
		);

		/**		
		 * post_type_archive_downloads_per_page
		*/
		$wp_customize->add_setting( 'post_type_archive_downloads_per_page', array(
			'default' => '',
			'sanitize_callback' => 'shopfront_sanitize_round_to_whole_number',
		));

		$wp_customize->add_control( new ShopFront_Custom_Text_Control( $wp_customize, 'post_type_archive_downloads_per_page', array(
		    'label' => __( 'Downloads Per Page', 'shop-front' ),
		    'section' => 'shopfront_section_shop',
		    'extra' => __( 'Leave blank to show all', 'shop-front' ),
		    ) ) 
		);

		
		/**		
		 * Download Columns
		*/
		$wp_customize->add_setting( 'download_columns', array(
			'default' => '3',
			'sanitize_callback' => 'shopfront_sanitize_download_columns',
		));
		

		$wp_customize->add_control( 'download_columns', array(
			'label' => __( 'Download Columns', 'shop-front' ),
			'section' => 'shopfront_section_shop',
			'type'    => 'select',
			'choices' => array(
				'1' => __( '1', 'shop-front' ),
				'2' => __( '2', 'shop-front' ),
				'3' => __( '3', 'shop-front' ),
				'4'	=> __( '4', 'shop-front' ),
			),
		));

		/**		
		 * Cart/basket icons
		 * @todo sanitize select, radio and checkbox fields
		*/
		$wp_customize->add_setting( 'cart_icon', array(
			'default' => 'cart',
		//	'sanitize_callback' => 'shopfront_sanitize_select',
		));

		$wp_customize->add_control( 'cart_icon', array(
			'label' => __( 'Display Cart or Basket?', 'shop-front' ),
			'section' => 'shopfront_section_shop',
			'type'    => 'select',
			'choices' => array(
				'cart' => __( 'Cart', 'shop-front' ),
				'basket' => __( 'Basket', 'shop-front' ),
			),
		));
		
		$wp_customize->add_setting( 'cart_show_icon', array(
			'default' => 1,
		//	'sanitize_callback' => 'shopfront_sanitize_checkbox',
		));

		$wp_customize->add_control( 'cart_show_icon', array(
			'label' => __( 'Show icon in navigation?', 'shop-front' ),
			'section' => 'shopfront_section_shop',
			'type'    => 'checkbox',
		));

		// icon alignment
		$wp_customize->add_setting( 'cart_icon_alignment', array(
			'default' => 'left',
			//	'sanitize_callback' => 'shopfront_sanitize_radio',
		));

		$wp_customize->add_control( 'cart_icon_alignment', array(
			'label' => __( 'Icon Alignment', 'shop-front' ),
			'section' => 'shopfront_section_shop',
			'type'    => 'radio',
			'choices' => array(
				'left' => __( 'Left', 'shop-front' ),
				'right' => __( 'Right', 'shop-front' ),
			),
		));

	} // end shopfront_edd_is_active()


	/**		
	 * blog posts to show
	*/
	$wp_posts_per_page = get_option('posts_per_page');

	$wp_customize->add_setting( 'blog_posts_per_page', array(
		'default' => $wp_posts_per_page,
		'sanitize_callback' => 'shopfront_sanitize_blog_posts_per_page',
	));

	$wp_customize->add_control( new ShopFront_Custom_Text_Control( $wp_customize, 'blog_posts_per_page', array(
	    'label' => __( 'Blog Template Posts Per Page', 'shop-front' ),
	    'section' => 'shopfront_section_blog',
	    'extra' => __( 'Leave blank to use the "Blog pages show at most" number under Settings &rarr; Reading. Enter -1 to show all blog posts.', 'shop-front' ),
	    ) ) 
	);

	/**		
	 * Use the_excerpt or the_content for blog page template
	*/
	$wp_customize->add_setting( 'blog_excerpt_or_content', array(
		'default' => 'excerpt',
	));

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'blog_excerpt_or_content', array(
	    'label' => __( 'Blog Template Posts Per Page', 'shop-front' ),
	    'section' => 'shopfront_section_blog',
	    'type'	=> 'radio',
	    'choices' => array(
	    	'excerpt' => __( 'Excerpts', 'shop-front' ),
	    	'content' => __( 'Full Content', 'shop-front' ),
	    	)
	    )) 
	);


	/**		
	 * Theme Style
	*/

	// only show if there is a styles folder
	$styles = shopfront_theme_options_theme_styles();

    if( $styles ) {

		$wp_customize->add_setting( 'theme_style', array(
			'default' => 'style.css',
			'sanitize_callback' => 'shopfront_sanitize_theme_style',
		));

		$wp_customize->add_control( 'theme_style', array(
			'label' => __( 'Theme Style', 'shop-front' ),
			'section' => 'shopfront_section_styling',
			'type'    => 'select',
			'choices'    => $styles
		));
	}


	/**		
	 * Logo
	*/
	$wp_customize->add_setting( 'logo', array(
		'default'        => '',
	) );

	$wp_customize->add_control( new ShopFront_Custom_Image_Control( $wp_customize, 'logo', array(
		'label'	=> __( 'Logo', 'shop-front' ),
		'section' => 'title_tagline',
	)));

	/**		
	 * typography
	*/

	// only show if there is more than 1 stylesheet
	$typography_styles = count( glob( get_stylesheet_directory() . '/typography/*.css' ) );

	if( $typography_styles > 1 ) {

		$wp_customize->add_setting( 'typography', array(
			'default' => 'default.css',
			'sanitize_callback' => 'shopfront_typography_sanitize_typography',
		));

		$typography = shopfront_get_typography_css_files( get_stylesheet_directory() . '/typography/', 'css', get_stylesheet_directory_uri() . '/typography/' );

		$wp_customize->add_control( 'typography', array(
			'label' => __( 'Typography Stylesheet', 'shopfront' ),
			'section' => 'shopfront_section_typography',
			'type'    => 'select',
			'priority' => 50,
			'choices'    => $typography
		));

	}

	// postMessage
	$wp_customize->get_setting( 'blogname' )->transport='postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport='postMessage';
	$wp_customize->get_setting( 'logo' )->transport='postMessage';
	$wp_customize->get_setting( 'copyright' )->transport='postMessage';


	if ( $wp_customize->is_preview() && ! is_admin() ) {
		add_action( 'wp_footer', 'shopfront_customize_preview', 21 );
	}

}

add_action( 'customize_register', 'shopfront_customize_register' );

/**		
 * Sanitization text field
 * @since 1.0 
*/

if ( ! function_exists( 'shopfront_sanitize_text_field' ) ) :
	function shopfront_sanitize_text_field( $input  ) {
		return sanitize_text_field( $input );
	}
endif;



/**		
 * Sanitize typography
 * @since 1.0 
*/
if ( ! function_exists( 'shopfront_typography_sanitize_typography' ) ) :
	function shopfront_typography_sanitize_typography( $input ) {
	    
	   	$valid = shopfront_get_typography_css_files( get_stylesheet_directory() . '/typography/', 'css', get_stylesheet_directory_uri() . '/typography/' );

	    if ( array_key_exists( $input, $valid ) ) 
	        return $input;
	    else 
	        return '';

	}
endif;

/**
 * Sanitize whole number
 *
 * @since 1.0
*/
if ( ! function_exists( 'shopfront_sanitize_round_to_whole_number' ) ) :
	function shopfront_sanitize_round_to_whole_number( $input  ) {
		
		if( '' == $input ) 
			return '-1';
		else 
			return wp_filter_nohtml_kses( round( $input ) );

	}
endif;

/**
 * Sanitize Blog posts
 *
 * @since 1.0
*/
if ( ! function_exists( 'shopfront_sanitize_blog_posts_per_page' ) ) :
	function shopfront_sanitize_blog_posts_per_page( $input  ) {

		$wp_posts_per_page = get_option('posts_per_page');

		// if nothing is entered we return the default blog posts per page setting
		if( !$input)
			return $wp_posts_per_page;
		else
			return wp_filter_nohtml_kses( round( $input ) );
	}
endif;



/**
 * Sanitize download columns
 *
 * @since 1.0
*/
if ( ! function_exists( 'shopfront_sanitize_download_columns' ) ) :
	function shopfront_sanitize_download_columns( $input ) {
	    
	    $valid = array(
	        '1' => __( '1', 'shop-front' ),
	        '2' => __( '2', 'shop-front' ),
	        '3' => __( '3', 'shop-front' ),
	        '4' => __( '4', 'shop-front' ),
	    );
	 
	    if ( array_key_exists( $input, $valid ) ) 
	        return $input;
	     else 
	        return '';

	}
endif;

/**
 * Santize theme styles
 *
 * @since 1.0
*/
if ( ! function_exists( 'shopfront_sanitize_theme_style' ) ) :
	function shopfront_sanitize_theme_style( $input ) {
	    
	   	$valid = shopfront_theme_options_theme_styles();
	 
	    if ( array_key_exists( $input, $valid ) ) 
	        return $input;
	    else 
	        return '';

	}
endif;

/**
 * PostMessage JS
 * @since 1.0
 */

function shopfront_customize_preview() {

?>

	<script type="text/javascript">
	( function( $ ){

	// logo image
	wp.customize('logo',function( value ) {
		value.bind(function(logo) {
			jQuery('#site-title a').html('<img src="' + logo + '" />');
		});
	});

	// blog name
	wp.customize('blogname',function( value ) {
		value.bind(function(to) {
			jQuery('#site-title a').html(to);
		});
	});

	// blog description
	wp.customize('blogdescription',function( value ) {
		value.bind(function(to) {
			jQuery('#site-description').html(to);
		});
	});

	// copyright
	wp.customize('copyright',function( value ) {
		value.bind(function(to) {
			jQuery('p.copyright').html(to);
		});
	});


	} )( jQuery )
	</script>
	<?php
}