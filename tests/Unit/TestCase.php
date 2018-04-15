<?php
/**
 * ShareQuote Unit TestCase to Extend
 *
 * @package   ShareQuote
 * @author    Craig Simpson <craig@craigsimpson.scot>
 * @license   GPL-2.0-or-later
 * @link      https://craigsimpson.scot
 * @copyright 2018 Craig Simpson
 */

namespace ShareQuote\Tests\Unit;

use Brain\Monkey;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * Class TestCase
 *
 * @package ShareQuote\Tests\Unit
 */
class TestCase extends \PHPUnit\Framework\TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * TestCase setUp method.
	 */
	protected function setUp() {
		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * TestCase tearDown method.
	 */
	protected function tearDown() {
		Monkey\tearDown();
		parent::tearDown();
	}
}
