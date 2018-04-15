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
class PluginShortcodeTest extends TestCase {

	/**
	 * Sample permalink.
	 */
	const PERMALINK = 'https://sharequote.localhost/sample-page';

	/**
	 * Sample page title.
	 */
	const TITLE = 'Sample Page';

	/**
	 * Sample shortcode content.
	 */
	const CONTENT = 'Etiam sagittis, urna quis lobortis tempus, est augue porta eros, ut convallis libero tortor eget lectus.';

	/**
	 * Property to hold array of default shortcode attributes.
	 *
	 * @var array $defaults Default shortcode attributes.
	 */
	private $defaults = [
		'align' => 'none',
	];

	/**
	 * Store an instance of the ShareQuote class.
	 *
	 * @var ShareQuote $sharequote Instance of the ShareQuote class.
	 */
	public $sharequote;

	/**
	 * Override default setUp method.
	 */
	protected function setUp() {
		Functions\when( 'shortcode_atts' )->alias( 'array_merge' );
		Functions\when( 'wp_enqueue_style' )->justReturn();
		Functions\when( 'get_the_permalink' )->justReturn( self::PERMALINK );
		Functions\when( 'get_the_title' )->justReturn( self::TITLE );

		$this->sharequote = new ShareQuote();

		parent::setUp();
	}

	/**
	 * Test that the ShareQuote shortcode returns false when no $content is set.
	 */
	public function test_sharequote_shortcode_returns_false_with_no_content_set() {
		self::assertFalse( $this->sharequote->shortcode() );
	}

	/**
	 * Test that the ShareQuote shortcode uses the default align attribute when none is set.
	 */
	public function test_sharequote_shortcode_uses_default_align_attribute_if_none_is_set() {
		self::assertEquals( 'none', $this->sharequote->get_sharequote_alignment() );
	}

	/**
	 * Test that the ShareQuote shortcode uses the custom align attribute when one is set.
	 */
	public function test_sharequote_shortcode_uses_align_attribute_if_set() {
		self::assertEquals( 'left', $this->sharequote->get_sharequote_alignment( 'left' ) );
	}
}
