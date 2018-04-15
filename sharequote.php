<?php
/**
 * ShareQuote
 *
 * Highlight important content and allow users to easily share it with their network.
 *
 * @package   ShareQuote
 * @author    Craig Simpson <craig@craigsimpson.scot>
 * @license   GPL-2.0-or-later
 * @link      https://craigsimpson.scot
 * @copyright 2018 Craig Simpson
 *
 * @wordpress-plugin
 * Plugin Name:       ShareQuote
 * Plugin URI:        https://craigsimpson.scot/sharequote
 * Description:       Highlight important content and allow users to easily share it with their network.
 * Version:           1.0.0
 * Author:            Craig Simpson
 * Author URI:        https://craigsimpson.scot/
 * License:           GPL-2.0-or-later
 * License URI:       https://spdx.org/licenses/GPL-2.0-or-later.html
 * Text Domain:       ShareQuote
 * Domain Path:       /languages
 *
 *
 * ShareQuote is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * ShareQuote is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ShareQuote. If not, see https://spdx.org/licenses/GPL-2.0-or-later.html.
 */

namespace ShareQuote;

defined( 'ABSPATH' ) || exit;

// Define plugin constants.
define( 'SHAREQUOTE_VERSION', '1.0.0' );
define( 'SHAREQUOTE_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SHAREQUOTE_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

// Load plugin textdomain.
load_plugin_textdomain( 'sharequote', false, '/languages' );

/**
 * Load the plugin class.
 *
 * @since 1.0.0
 */
require_once 'includes/class-sharequote.php';

/**
 * Start the engine.
 *
 * @since 1.0.0
 */
$sharequote = new ShareQuote();
$sharequote->init();
