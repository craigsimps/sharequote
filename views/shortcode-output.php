<?php
/**
 * View: [sharequote] shortcode output.
 *
 * @package   ShareQuote
 * @author    Craig Simpson <craig@craigsimpson.scot>
 * @license   GPL-2.0-or-later
 * @link      https://craigsimpson.scot
 * @copyright 2018 Craig Simpson
 *
 * @param string $alignment ShareQuote alignment, from left|right|none.
 * @param string $content Shortcode content.
 * @param array  $sharing_links Array of social sharing links, with structure 'network' => 'url'.
 */

namespace ShareQuote;

?>
<div class="sharequote <?php echo esc_attr( $alignment ); ?>">
	<figure class="sharequote__container">
		<blockquote>
			<p><?php echo esc_html( $content ); ?></p>
		</blockquote>
	</figure>
	<div class="sharequote__buttons">
		<ul>
			<?php foreach ( $sharing_links as $network => $share_link ) { ?>
				<li>
					<a href="<?php echo esc_url( $share_link ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo esc_url( SHAREQUOTE_URL . 'assets/images/' . $network . '.svg' ); ?>">
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>
