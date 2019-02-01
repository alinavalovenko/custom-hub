<?php
/*
	Plugin Name: Custom Hub
	Description: CTP Hub and his functionality
	Version: 1.0
	Author: Alina Valovenko
	Author URI: http://www.valovenko.pro
	License: GPL2
*/
register_activation_hook( plugin_basename( __FILE__ ), 'hub_activate' );
register_deactivation_hook( plugin_basename( __FILE__ ), 'hub_deactivate' );
register_uninstall_hook( plugin_basename( __FILE__ ), 'hub_uninstall' );

add_action( 'wp_enqueue_scripts', 'custom_hub_scripts' );
function custom_hub_scripts() {
	wp_enqueue_style( 'custom-hub-style', plugin_dir_url( __FILE__ ) . 'css/styles.css' );
	wp_enqueue_style( 'custom-hub-slick-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array( 'custom-hub-style' ) );
	wp_enqueue_script( 'custom-hub-script', plugin_dir_url( __FILE__ ) . 'js/scripts.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'custom-hub-slick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array( 'custom-hub-script' ), '1.0.0', true );
}

function hub_activate() {
	return true;
}

function hub_deactivate() {
	return true;
}

function hub_uninstall() {
	return true;
}

/**
 * Create Custom post type hubpost
 **/
add_action( 'init', 'hubpost_init' );
function hubpost_init() {
	register_post_type( 'hubpost', array(
		'labels'             => array(
			'name'          => 'Hub Posts',
			'singular_name' => 'Hub Post',
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'post-formats' ),

	) );
}

/**
 * Create taxonomy for post type 'hubpost'
 */
add_action( 'init', 'hubcategory_init' );
function hubcategory_init() {
	register_taxonomy( 'hubcategory',
		'hubpost',
		array(
			'labels'            => array(
				'name'          => esc_html__( 'Hub Categories' ),
				'singular_name' => esc_html__( 'Hub Category' ),
				'search_items'  => esc_html__( 'Hub Categories' ),
				'all_items'     => esc_html__( 'Hub Categories' ),
				'view_item '    => esc_html__( 'Hub Category' ),
				'edit_item'     => esc_html__( 'Hub Category' ),
				'update_item'   => esc_html__( 'Hub Category' ),
				'add_new_item'  => esc_html__( 'Hub Category' ),
				'new_item_name' => esc_html__( 'Hub Category' ),
				'menu_name'     => esc_html__( 'Hub Categories' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite'           => false,
			'query_var'         => true,
		) );

	register_taxonomy( 'hupostformat',
		'hubpost',
		array(
			'labels'            => array(
				'name'          => esc_html__( 'Hub Format' ),
				'singular_name' => esc_html__( 'Hub Format' ),
				'search_items'  => esc_html__( 'Hub Format' ),
				'all_items'     => esc_html__( 'Hub Format' ),
				'view_item '    => esc_html__( 'Hub Format' ),
				'edit_item'     => esc_html__( 'Hub Format' ),
				'update_item'   => esc_html__( 'Hub Format' ),
				'add_new_item'  => esc_html__( 'Hub Format' ),
				'new_item_name' => esc_html__( 'Hub Format' ),
				'menu_name'     => esc_html__( 'Hub Formats' ),
			),
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite'           => true,
			'query_var'         => true,
		) );
}

/**
 * Add custom fields to hubpost post type
 */
if ( function_exists( 'acf_add_local_field_group' ) ):

	acf_add_local_field_group( array(
		'key'                   => 'group_5c3df279ec483',
		'title'                 => 'Article Settings',
		'fields'                => array(
			array(
				'key'               => 'field_5c3df2eb22545',
				'label'             => 'Article URL',
				'name'              => 'article_url',
				'type'              => 'url',
				'instructions'      => 'including https://www......',
				'required'          => 1,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '50',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => 'https://www.domain.com/123',
			), // external permalink
			array(
				'key'          => 'field_hubpost_source',
				'label'        => 'Hub Post Source',
				'name'         => 'hubpost_source',
				'type'         => 'text',
				'wrapper'      => array(
					'width' => '50',
					'class' => '',
					'id'    => '',
				),
				'instructions' => 'For example: AARP',
			) //Custom author field
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'hubpost',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'acf_after_title',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'field',
		'hide_on_screen'        => '',
		'active'                => 1,
		'description'           => '',
	) );
	acf_add_local_field_group( array(
		'key'                   => 'group_5c3f4bd570c4a',
		'title'                 => 'Hub Format Option',
		'fields'                => array(
			array(
				'key'               => 'field_5c3f4c055db85',
				'label'             => 'Icon',
				'name'              => 'hub_format_icon',
				'type'              => 'image',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'return_format'     => 'url',
				'preview_size'      => 'thumbnail',
				'library'           => 'all',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => '',
			),
			array(
				'key' => 'field_5c543479c9555',
				'label' => 'CTA Title',
				'name' => 'cta_title',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'Read me',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'hupostformat',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => 1,
		'description'           => '',
	) );

endif;

add_shortcode( 'hubpost', 'hubpost_shortcode_render' );

/***
 * Shortcode render function
 *
 * @param $atts
 *
 * @return false|string
 */
function hubpost_shortcode_render( $atts ) {
	global $post;
	$output   = '';
	$taxonomy = 'hupostformat';
	$hub_data = shortcode_atts( array(
		'category' => '',
		'posttype' => 'hubpost',
		'limit'    => '-1',
		'style'    => 'default',
	), $atts, 'hubpost' );
	ob_start();
	$args = array(
		'post_type'   => $hub_data['posttype'], // change post type if it necessary
		'numberposts' => $hub_data['limit'], // manage amount of items
		'orderby'     => 'date',
		'order'       => 'DESC',
		'tax_query'   => prepare_tax_query( $hub_data['category'] ) // change category of post type if it necessary
	);

	$posts = get_posts( $args ); // get all articles by post type and categories
	echo '<div class="hubcategory-wrap hubcategory-' . $hub_data['style'] . '">'; // shortcode wrap start
	foreach ( $posts as $post ) {
		$primary_link = get_post_meta( $post->ID, 'article_url', true ); // get primary link
		$format_term  = wp_get_post_terms( $post->ID, $taxonomy );
		switch ( $hub_data['style'] ) {
			case 'slider':
				slider_hubpost_thumbnail_markup( $primary_link, $format_term[0], $post->ID );
				break;
			default:
				single_hubpost_thumbnail_markup( $primary_link, $format_term[0], $post->ID );
		}

	}
	echo '</div>'; // shortcode wrap end
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}


/**
 * Convert short code parameter to correct tax_query array
 *
 * @param $terms string from shortcode
 * @param $taxonomy = 'hubcategory' main taxonomy
 *
 * @return array
 */
function prepare_tax_query( $terms, $taxonomy = 'hubcategory' ) {
	$term_slugs = array();
	if ( empty( $terms ) ) {
		$terms = get_terms( $taxonomy );
		foreach ( $terms as $term ) {
			array_push( $term_slugs, $term->slug );
		}
	} else {
		$term_slugs = $terms;
	}
	$tax_query = array(
		array(
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => $term_slugs
		)
	);

	return $tax_query;
}


/**
 * Mark up for custom single item
 *
 * @param $permalink
 * @param $format_term - term icon url
 * @param $post_id - item id
 *
 */
function single_hubpost_thumbnail_markup( $permalink, $format_term, $post_id ) {
	$format_icon_id = get_term_meta( $format_term->term_id, 'hub_format_icon', true );
	?>
    <div class="hubpost-card">
        <a href="<?php echo $permalink; ?>" class="hubpost-link" target="_blank">
        	<span class="hubpost-image">
				<?php echo get_the_post_thumbnail( $post_id, 'magazine', array( 'class' => 'magazine' ) ); ?>
				<?php if ( ! empty( $format_icon_id ) ) : ?>
			</span>
            <span class="post-format-wrap">
	        <span class="post-format-icon"><?php echo wp_get_attachment_image( $format_icon_id, 'hub-content-format', array( 'class' => 'hub-content-format' ) ) ?></span>
			<?php endif; ?>
			</span>
            <span class="hubpost-title"><?php echo get_the_title( $post_id ); ?></span>
            <span class="hubpost-source"><?php echo get_post_meta( $post_id, 'hubpost_source', true ); ?></span>
            <span class="hubpost-format-text"><?php echo $format_term->name; ?></span>
            <!-- strtoupper - make all letters big -->
            <span class="hubpost-excerp"><?php echo get_the_excerpt( $post_id ); ?></span>
        </a>
    </div>
	<?php
}

function slider_hubpost_thumbnail_markup( $permalink, $format_term, $post_id ) {
	$format_icon_id = get_term_meta( $format_term->term_id, 'hub_format_icon', true );
	$cta_text = get_field('cta_title', $format_term);
	?>
    <div class="hubpost-card-slide">
    <div class="hubpost-columns">    
        <div class="hubpost-col">
            <a href="<?php echo $permalink; ?>" class="hubpost-link" target="_blank">
        	<span class="hubpost-image">
				<?php echo get_the_post_thumbnail( $post_id, 'magazine', array( 'class' => 'magazine' ) ); ?>
            </span>
            </a>
        </div>
        <div class="hubpost-col">
            <div class="hubpost-title"><a href="<?php echo $permalink; ?>" class="hubpost-link" target="_blank"><?php echo get_the_title( $post_id ); ?></a></div>
            <div class="hubpost-source">By <?php echo get_post_meta( $post_id, 'hubpost_source', true ); ?></div>
            <div class="hubpost-excerp"><?php echo get_the_excerpt( $post_id ); ?></div>

			<?php if ( ! empty( $format_icon_id ) ) : ?>
                <div class="post-format-wrap">
                    <a href="<?php echo $permalink; ?>" class="hubpost-link" target="_blank">
                    <span class="post-format-icon"><?php echo wp_get_attachment_image( $format_icon_id, 'hub-content-format', array( 'class' => 'hub-content-format' ) ) ?></span>
                    <span class="hubpost-format-text"><?php echo $cta_text ? $cta_text : $format_term->name; ?></span>
                	</a>
                </div>
			<?php endif; ?>
        </div>
    </div>
    </div>
	<?php
}
