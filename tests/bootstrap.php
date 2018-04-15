<?php
/**
 * PHPUnit Bootstrap
 *
 * @package   ShareQuote
 * @author    Craig Simpson <craig@craigsimpson.scot>
 * @license   GPL-2.0-or-later
 * @link      https://craigsimpson.scot
 * @copyright 2018 Craig Simpson
 */

declare( strict_types=1 );

namespace ShareQuote\Tests;

// Load dependencies.
$plugins_dir = dirname( __DIR__, 1 );
require_once $plugins_dir . '/vendor/autoload.php';
