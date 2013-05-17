<?php
/**
 * Add support for Theme Options in the Customizer
 */


/**		
 * Add 'Customize' link to admin menu under 'Appearance'
*/

function shopfront_add_customize() {
	add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}
add_action ('admin_menu', 'shopfront_add_customize');

/**		
 * Add some basic styling for extra field descriptions
*/
function shopfront_style_customize() { ?>
	<style>
		.customize-control-extra {
			color: #999999;
			display:block;
			margin-top: 4px;
		}

		textarea {
			width: 98%;
		}
	</style>
<?php }
add_action('customize_controls_print_styles', 'shopfront_style_customize');


function shopfront_customize_register( $wp_customize ) {

	/**		
	 * Remove background image section
	*/

	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_section( 'static_front_page' );

	/**		
	 * Remove controls
	*/
	$wp_customize->remove_control( 'blogdescription' );


	/**		
	 * Custom controls
	*/

	class Custom_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() { ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	<?php }
	}

	// custom text control with 'extra' section
    class Custom_Text_Control extends WP_Customize_Control {
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
	 
	class Custom_Image_Control extends WP_Customize_Image_Control {
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



	// contact
	$wp_customize->add_section( 'shopfront_section_contact', array(
		'title'		=> __( 'Contact Page Template', 'shop-front' ),
		'priority'	=> 50,
		'description' => 'Contact',
	));

	// blog
	$wp_customize->add_section( 'shopfront_section_blog', array(
		'title'		=> __( 'Blog Page Template', 'shop-front' ),
		'priority'	=> 50,
		'description' => 'Blog',
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

		
	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'copyright', array(
	    'label' => __( 'Copyright' , 'shop-front' ),
	    'section' => 'shopfront_section_footer',
	    'settings' => 'copyright',
	    //'extra' => __( '%year% Current Year, %sitetitle% = Site Title' , 'shop-front' ),
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

			$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'home_featured_downloads', array(
			    'label' => __( 'Featured Downloads To Show' , 'shop-front' ),
			    'section' => 'shopfront_section_homepage',
			    'extra' => __( '-1 shows all downloads. Leave blank to disable.' , 'shop-front' ),
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

		$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'home_latest_downloads', array(
		    'label' => __( 'Latest Downloads To Show' , 'shop-front' ),
		    'section' => 'shopfront_section_homepage',
		    'extra' => __( 'Leave blank to show all. Enter 0 to disable.' , 'shop-front' ),
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
			'label' => __( 'Download Columns' , 'shop-front' ),
			'section' => 'shopfront_section_homepage',
			'type'    => 'select',
			'choices' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4'	=> '4'
			),
		));

		/**		
		 * Home Button Text
		*/


		$wp_customize->add_setting( 'home_button_text', array(
			'default' => __( 'View all' , 'shop-front' ),
			'sanitize_callback' => 'shopfront_sanitize_text_field',
		));

		$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'home_button_text', array(
		    'label' => __( 'Button Text' , 'shop-front' ),
		    'section' => 'shopfront_section_homepage',
		    'extra' => __( 'Leave blank to disable.' , 'shop-front' ),
		    ) ) 
		);

		/**		
		 * shop title
		*/

		

		$wp_customize->add_setting( 'post_type_archive_title', array(
			'default' => get_post_type_object('download')->labels->menu_name,
			'sanitize_callback' => 'shopfront_sanitize_text_field',
		));

		$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'post_type_archive_title', array(
		    'label' => __( 'Shop Title' , 'shop-front' ),
		    'section' => 'shopfront_section_shop',
		    'extra' => __( 'Leave blank to disable' , 'shop-front' ),
		    ) ) 
		);

		/**		
		 * post_type_archive_downloads_per_page
		*/
		$wp_customize->add_setting( 'post_type_archive_downloads_per_page', array(
			'default' => '',
			'sanitize_callback' => 'shopfront_sanitize_round_to_whole_number',
		));

		$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'post_type_archive_downloads_per_page', array(
		    'label' => __( 'Downloads Per Page' , 'shop-front' ),
		    'section' => 'shopfront_section_shop',
		    'extra' => __( 'Leave blank to show all' , 'shop-front' ),
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
			'label' => __( 'Download Columns' , 'shop-front' ),
			'section' => 'shopfront_section_shop',
			'type'    => 'select',
			'choices' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4'	=> '4'
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

	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'blog_posts_per_page', array(
	    'label' => __( 'Blog Template Posts Per Page' , 'shop-front' ),
	    'section' => 'shopfront_section_blog',
	    'extra' => __( 'Leave blank to use the "Blog pages show at most" number under Settings &rarr; Reading. Enter -1 to show all blog posts.' , 'shop-front' ),
	    ) ) 
	);

	/**		
	 * Use the_excerpt or the_content for blog page template
	*/
	$wp_customize->add_setting( 'blog_excerpt_or_content', array(
		'default' => 'excerpt',
	));

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'blog_excerpt_or_content', array(
	    'label' => __( 'Blog Template Posts Per Page' , 'shop-front' ),
	    'section' => 'shopfront_section_blog',
	    'type'	=> 'radio',
	    'choices' => array(
	    	'excerpt' => 'Excerpts',
	    	'content' => 'Full Content'
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
		//	'sanitize_callback' => 'shopfront_sanitize_theme_style',
		));

		$wp_customize->add_control( 'theme_style', array(
			'label' => __( 'Theme Style' , 'shop-front' ),
			'section' => 'shopfront_section_styling',
			'type'    => 'select',
			'choices'    => $styles
		));
	}

	
	

	/**		
	 * Contact Form Email Address
	*/
	$wp_customize->add_setting( 'contact_form_email', array(
		'default' => '',
		'sanitize_callback' => 'shopfront_sanitize_email',
	));

	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'contact_form_email', array(
	    'label' => __( 'Contact Form Email Address' , 'shop-front' ),
	    'section' => 'shopfront_section_contact',
	    'extra' => __( 'Leave blank to use admin email' , 'shop-front' ),
	    ) ) 
	);


	/**		
	 * Contact Form Message
	*/
	$wp_customize->add_setting( 'contact_form_message', array(
		'default' => __('Thanks for getting in touch!', 'shop-front'),
		'sanitize_callback' => 'shopfront_sanitize_text_field',
	));

	// contact form success message
	$wp_customize->add_control( new Custom_Textarea_Control( $wp_customize, 'contact_form_message', array(
		'label' => __( 'Contact Form Success Message' , 'shop-front' ),
		'section'	=> 'shopfront_section_contact',
		) ) 
	);


	/**		
	 * Logo
	*/
	$wp_customize->add_setting( 'logo', array(
		'default'        => '',
	) );

	$wp_customize->add_control( new Custom_Image_Control( $wp_customize, 'logo', array(
		'label'	=> __( 'Logo', 'shop-front' ),
		'section' => 'title_tagline',
	)));



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
 * Sanitization callbacks
*/
function shopfront_sanitize_text_field( $input  ) {
	return sanitize_text_field( $input );
}



function shopfront_sanitize_round_to_whole_number( $input  ) {
	
	if( '' == $input ) {
		return '-1';
	} else {
		return wp_filter_nohtml_kses( round( $input ) );
	}
		
	
}


function shopfront_sanitize_blog_posts_per_page( $input  ) {

	$wp_posts_per_page = get_option('posts_per_page');

	// if nothing is entered we return the default blog posts per page setting
	if( !$input)
		return $wp_posts_per_page;
	else
		return wp_filter_nohtml_kses( round( $input ) );
}

function shopfront_sanitize_email( $input ) {
	return wp_filter_nohtml_kses( sanitize_email( $input ) ); 
}




function shopfront_sanitize_download_columns( $input ) {
    
    $valid = array(
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}



function shopfront_sanitize_theme_style( $input ) {
    
   	$valid = shopfront_theme_options_theme_styles();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}





/**
 * PostMessage JS
 */

function shopfront_customize_preview() {

?>

	<script type="text/javascript">
	( function( $ ){

	// logo image
	wp.customize('logo',function( value ) {
		value.bind(function(logo) {
			jQuery('#site-title a').html('<img src="' + logo + '" />');
			// $('.posttitle').css('color', to ? '#' + to : '' );
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