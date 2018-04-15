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
 * @param string $alignment Alignment value from $atts, left|right|none.
 * @param string $permalink URL of current post.
 * @param string $link_title Post title, wrapped with rawurlencode.
 * @param string $link_content Our ShareQuote snippet, wrapped with rawurlencode.
 */

namespace ShareQuote;

?>
<div class="sharequote <?php echo esc_attr( 'sharequote--align-' . $alignment ); ?>">
	<figure class="sharequote__container">
		<blockquote>
			<?php echo wp_kses_post( wpautop( $content ) ); ?>
		</blockquote>
	</figure>
	<div class="sharequote__buttons">
		<ul>
			<li>
				<a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr( $link_content ); ?>&url=<?php echo esc_url( $permalink ); ?>" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo esc_url( SHAREQUOTE_URL . 'assets/images/twitter.svg' ); ?>">
				</a>
			</li>
			<li>
				<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( $permalink ); ?>" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo esc_url( SHAREQUOTE_URL . 'assets/images/facebook.svg' ); ?>">
				</a>
			</li>
			<li>
				<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( $permalink ); ?>&title=<?php echo esc_attr( $link_title ); ?>&summary=<?php echo esc_attr( $link_content ); ?>&source=<?php echo esc_url( home_url() ); ?>" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo esc_url( SHAREQUOTE_URL . 'assets/images/linkedin.svg' ); ?>">
				</a>
			</li>
		</ul>
	</div>
</div>
