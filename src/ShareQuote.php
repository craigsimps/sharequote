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
	public function shortcode( $atts, $content ) {
		// Should always have content, as we want to wrap our ShareQuote quote.
		if ( empty( $content ) ) {
			return false;
		}

		// Retrieve shortcode attributes, merge with defaults.
		$atts = shortcode_atts( $this->defaults, $atts );

		// Enqueue CSS styles.
		wp_enqueue_style( 'sharequote' );

		// Retrieve values required in links.
		$alignment    = ! empty( $atts['align'] ) ? $atts['align'] : 'none';
		$permalink    = get_the_permalink();
		$link_title   = rawurlencode( get_the_title() );
		$link_content = rawurlencode( $content );

		ob_start();
		include SHAREQUOTE_DIR . 'views/shortcode-output.php';

		return ob_get_clean();
	}
}
