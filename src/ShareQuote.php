<?php
/**
 * Main plugin class.
 *
 * @package   ShareQuote
 * @author    Craig Simpson <craig@craigsimpson.scot>
 * @license   GPL-2.0-or-later
 * @link      https://craigsimpson.scot
 * @copyright 2018 Craig Simpson
 */

namespace ShareQuote;

/**
 * Class ShareQuote
 *
 * @package ShareQuote
 */
class ShareQuote {

	/**
	 * Property to hold array of default shortcode attributes.
	 *
	 * @var array $defaults Default shortcode attributes.
	 */
	public $defaults;

	/**
	 * ShareQuote constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->defaults = [
			'align' => 'none',
		];
	}

	/**
	 * Attach ShareQuote hooks, filters and shortcode.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_shortcode( 'sharequote', [ $this, 'shortcode' ] );
	}

	/**
	 * Register ShareQuote assets.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		wp_register_style( 'sharequote', SHAREQUOTE_URL . 'assets/css/sharequote.css', [], SHAREQUOTE_VERSION );
	}

	/**
	 * Render our ShareQuote content.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $atts Attributes passed from shortcode.
	 * @param string $content Shortcode content, our ShareQuote content.
	 *
	 * @return bool|string
	 */
	public function shortcode( $atts = [], $content = false ) {
		// Should always have content, as we want to wrap our ShareQuote quote.
		if ( empty( $content ) ) {
			return false;
		}

		// Retrieve shortcode attributes, merge with defaults.
		$atts = shortcode_atts( $this->defaults, $atts );

		// Enqueue CSS styles.
		if ( true !== apply_filters( 'sharequote_disable_stylesheet', false ) ) {
			wp_enqueue_style( 'sharequote' );
		}

		// Set ShareQuote alignment.
		$alignment = $this->get_sharequote_alignment( $atts['align'] );

		// Retrieve values required in links.
		$link = [
			'url'     => $this->get_sharequote_post_link(),
			'title'   => $this->get_sharequote_post_link_title(),
			'content' => $this->get_sharequote_post_link_content( $content ),
		];

		// Retrieve link templates.
		$templates     = $this->get_sharequote_post_link_templates();
		$sharing_links = $this->get_sharequote_share_links( $link, $templates );

		ob_start();
		include SHAREQUOTE_DIR . 'views/shortcode-output.php';

		return ob_get_clean();
	}

	/**
	 * Determine alignment of ShareQuote based on shortcode attributes.
	 *
	 * @param string $alignment Alignment of ShareQuote, expected left|right|none.
	 *
	 * @return string
	 */
	public function get_sharequote_alignment( $alignment = '' ) {
		return 'sharequote--align-' . ( in_array( $alignment, [ 'left', 'right', 'none' ], true ) ? $alignment : $this->defaults['align'] );
	}

	/**
	 * Determine post link for ShareQuote.
	 *
	 * Most of the time the shortcode will be used in posts and pages, but sometimes
	 * it might output in archives, search results, or other places where
	 * get_the_permalink() might not function. For those cases, lets just fall back
	 * to the home_url() until I can come up with something better.
	 *
	 * @return false|string
	 */
	public function get_sharequote_post_link() {
		return get_the_permalink() ?: home_url();
	}

	/**
	 * Encode the post title for inclusion in links.
	 *
	 * @return string
	 */
	public function get_sharequote_post_link_title() {
		return rawurlencode( get_the_title() );
	}

	/**
	 * Encode the ShareQuote content for inclusion in links.
	 *
	 * @param string $content ShareQuote shortcode content.
	 *
	 * @return string
	 */
	public function get_sharequote_post_link_content( $content ) {
		return rawurlencode( $content );
	}

	/**
	 * ShareQuote post link templates.
	 *
	 * Social network name as array key, template for link output as value,
	 * using placeholders for replacement later when outputting inside
	 * shortcode.
	 *
	 * @return array
	 */
	public function get_sharequote_post_link_templates() {
		return apply_filters( 'sharequote_post_link_templates', [
			'twitter'  => 'https://twitter.com/intent/tweet?text={CONTENT}&url={PERMALINK}',
			'facebook' => 'https://www.facebook.com/sharer/sharer.php?u={PERMALINK}',
			'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url={PERMALINK}&title={TITLE}&summary={CONTENT}&source={PERMALINK}',
		] );
	}

	/**
	 * Build an array of sharing links from our link values and templates.
	 *
	 * @param array $link Link parameters.
	 * @param array $templates Social sharing link templates with {PLACEHOLDERS}.
	 *
	 * @return array
	 */
	public function get_sharequote_share_links( $link, $templates ) {
		$links = [];
		foreach ( $templates as $network => $template ) {
			$links[ $network ] = $this->get_sharequote_link_from_template( $link, $template );
		}

		return $links;
	}

	/**
	 * Perform string replacements on link template to generate sharing url.
	 *
	 * @param array  $link Link parameters.
	 * @param string $template Single social sharing link template with {PLACEHOLDERS}.
	 *
	 * @return string
	 */
	public function get_sharequote_link_from_template( $link, $template ) {
		$share_link = str_replace( '{PERMALINK}', $link['url'], $template );
		$share_link = str_replace( '{TITLE}', $link['title'], $share_link );
		$share_link = str_replace( '{CONTENT}', $link['content'], $share_link );

		return $share_link;
	}
}
