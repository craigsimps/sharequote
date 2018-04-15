<?php
/**
 * ShareQuote Plugin Setup Test
 *
 * @package   ShareQuote
 * @author    Craig Simpson <craig@craigsimpson.scot>
 * @license   GPL-2.0-or-later
 * @link      https://craigsimpson.scot
 * @copyright 2018 Craig Simpson
 */

namespace ShareQuote\Tests\Unit;

use ShareQuote\ShareQuote;
use Brain\Monkey\Functions;

/**
 * Class PluginSetupTest
 *
 * @package ShareQuote\Tests\Unit
 */
class PluginSetupTest extends TestCase {

	/**
	 * Property to hold array of default shortcode attributes.
	 *
	 * @var array $defaults Default shortcode attributes.
	 */
	private $defaults = [
		'align' => 'none',
	];

	/**
	 * Test ShareQuote class can be instantiated.
	 */
	public function test_plugin_can_be_instantiated() {
		self::assertInstanceOf( ShareQuote::class, new ShareQuote() );
	}

	/**
	 * Test plugin defaults are set when ShareQuote is instantiated.
	 */
	public function test_plugin_sets_sharequote_default_shortcode_atts() {
		self::assertSame( $this->defaults, ( new ShareQuote() )->defaults );
	}

	/**
	 * Test that ShareQuote attaches our `enqueue_assets` callback when plugin is initialized.
	 */
	public function test_plugin_enqueues_assets() {
		Functions\when( 'add_shortcode' )->justReturn();
		( new ShareQuote() )->init();
		self::assertTrue( has_action( 'wp_enqueue_scripts', 'ShareQuote\ShareQuote->enqueue_assets()' ) );
	}

	/**
	 * Test that ShareQuote fires `add_shortcode` when plugin is initialized.
	 */
	public function test_plugin_adds_shortcode() {
		Functions\expect( 'add_shortcode' )->once();
		( new ShareQuote() )->init();
	}
}
