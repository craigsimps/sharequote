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
use Brain\Monkey\Filters;
use Brain\Monkey\Functions;

/**
 * Class PluginSetupTest
 *
 * @package ShareQuote\Tests\Unit
 */
class PluginShortcodeTest extends TestCase {

	const HOME = 'https://sharequote.localhost';

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
		Functions\when( 'get_the_title' )->justReturn( self::TITLE );
		Functions\when( 'home_url' )->justReturn( self::HOME );

		Functions\stubs( [
			'wp_enqueue_style',
			'esc_attr',
			'esc_url',
			'wp_kses_post',
			'wpautop',
		] );

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
		self::assertEquals( 'sharequote--align-none', $this->sharequote->get_sharequote_alignment() );
	}

	/**
	 * Test that the ShareQuote shortcode falls back to default attribute when one is set that isn't a preset option.
	 */
	public function test_sharequote_shortcode_uses_default_align_attribute_if_random_alignment_is_set() {
		self::assertEquals( 'sharequote--align-none', $this->sharequote->get_sharequote_alignment( 'bananas' ) );
	}

	/**
	 * Test that the ShareQuote shortcode uses the custom align attribute when one is set.
	 */
	public function test_sharequote_shortcode_uses_align_attribute_if_set() {
		self::assertEquals( 'sharequote--align-left', $this->sharequote->get_sharequote_alignment( 'left' ) );
	}

	/**
	 * Test that the ShareQuote shortcode post link is set to the current post permalink when it exists.
	 */
	public function test_sharequote_shortcode_post_link_is_set_to_permalink_when_it_exists() {
		Functions\when( 'get_the_permalink' )->justReturn( self::PERMALINK );
		self::assertEquals( self::PERMALINK, $this->sharequote->get_sharequote_post_link() );
	}

	/**
	 * Test the the ShareQuote shortcode post link falls back to the home_url when no post permalink exists.
	 */
	public function test_sharequote_shortcode_post_link_falls_back_to_home_url_when_no_permalink() {
		Functions\when( 'get_the_permalink' )->justReturn( false );
		self::assertEquals( self::HOME, $this->sharequote->get_sharequote_post_link() );
	}

	/**
	 * Test that the ShareQuote shortcode post title is prepared for placing into URLs.
	 */
	public function test_sharequote_shortcode_post_title_is_prepared_for_url_output() {
		self::assertNotEquals( self::TITLE, $this->sharequote->get_sharequote_post_link_title() );
	}

	/**
	 * Test that the ShareQuote shortcode post title is prepared for placing into URLs.
	 */
	public function test_sharequote_shortcode_content_is_prepared_for_url_output() {
		self::assertNotEquals( self::CONTENT, $this->sharequote->get_sharequote_post_link_content( self::CONTENT ) );
	}

	/**
	 * Test that the sharequote_post_link_templates filter is applied.
	 */
	public function test_sharequote_shortcode_post_link_templates_filter_is_applied() {
		$this->sharequote->get_sharequote_post_link_templates();
		self::assertTrue( Filters\applied( 'sharequote_post_link_templates' ) > 0 );
	}

	/**
	 * Test that the Sharequote shortcode share links are generated correctly.
	 */
	public function test_sharequote_shortcode_share_link_strings_are_generated_correctly() {
		$link = [
			'url'     => self::PERMALINK,
			'title'   => rawurlencode( self::TITLE ),
			'content' => rawurlencode( self::CONTENT ),
		];

		$sharing_links = [
			'twitter'  => 'https://twitter.com/intent/tweet?text=Etiam%20sagittis%2C%20urna%20quis%20lobortis%20tempus%2C%20est%20augue%20porta%20eros%2C%20ut%20convallis%20libero%20tortor%20eget%20lectus.&url=https://sharequote.localhost/sample-page',
			'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=https://sharequote.localhost/sample-page',
			'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=https://sharequote.localhost/sample-page&title=Sample%20Page&summary=Etiam%20sagittis%2C%20urna%20quis%20lobortis%20tempus%2C%20est%20augue%20porta%20eros%2C%20ut%20convallis%20libero%20tortor%20eget%20lectus.&source=https://sharequote.localhost/sample-page',
		];

		self::assertEquals( $sharing_links, $this->sharequote->get_sharequote_share_links( $link, $this->sharequote->get_sharequote_post_link_templates() ) );
	}
}
