<?php
/**
 * crybaby website functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since crybaby website 1.0
 */

if ( ! function_exists( 'crybaby_website_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since crybaby website 1.0
	 *
	 * @return void
	 */
	function crybaby_website_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'crybaby_website_post_format_setup' );

if ( ! function_exists( 'crybaby_website_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since crybaby website 1.0
	 *
	 * @return void
	 */
	function crybaby_website_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'crybaby_website_editor_style' );

if ( ! function_exists( 'crybaby_website_enqueue_styles' ) ) :
	/**
	 * Enqueues the theme stylesheet on the front.
	 *
	 * @since crybaby website 1.0
	 *
	 * @return void
	 */
	function crybaby_website_enqueue_styles() {
		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$src    = 'style' . $suffix . '.css';

		wp_enqueue_style(
			'crybaby-website-style',
			get_parent_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'crybaby-website-style',
			'path',
			get_parent_theme_file_path( $src )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'crybaby_website_enqueue_styles' );

if ( ! function_exists( 'crybaby_website_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since crybaby website 1.0
	 *
	 * @return void
	 */
	function crybaby_website_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'crybaby-website' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'crybaby_website_block_styles' );

if ( ! function_exists( 'crybaby_website_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since crybaby website 1.0
	 *
	 * @return void
	 */
	function crybaby_website_pattern_categories() {

		register_block_pattern_category(
			'crybaby_website_page',
			array(
				'label'       => __( 'Pages', 'crybaby-website' ),
				'description' => __( 'A collection of full page layouts.', 'crybaby-website' ),
			)
		);

		register_block_pattern_category(
			'crybaby_website_post-format',
			array(
				'label'       => __( 'Post formats', 'crybaby-website' ),
				'description' => __( 'A collection of post format patterns.', 'crybaby-website' ),
			)
		);
	}
endif;
add_action( 'init', 'crybaby_website_pattern_categories' );

if ( ! function_exists( 'crybaby_website_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since crybaby website 1.0
	 *
	 * @return void
	 */
	function crybaby_website_register_block_bindings() {
		register_block_bindings_source(
			'crybaby-website/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'crybaby-website' ),
				'get_value_callback' => 'crybaby_website_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'crybaby_website_register_block_bindings' );

if ( ! function_exists( 'crybaby_website_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since crybaby website 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function crybaby_website_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
