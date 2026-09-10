<?php
/**
 * Single content template.
 *
 * @package RLX_Signal
 */

get_header();
?>
<main id="main" class="inner-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<header class="page-hero">
			<p><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></p>
			<h1><?php the_title(); ?></h1>
		</header>
		<article <?php post_class( 'content-shell single-content' ); ?>>
			<?php $image = rlx_signal_post_image_url( get_the_ID(), 'rlx_image' ); ?>
			<?php if ( $image ) : ?>
				<img class="single-featured" src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>" width="1180" height="720">
			<?php endif; ?>
			<?php if ( 'rlx_news' === get_post_type() ) : ?>
				<p class="single-meta"><?php echo esc_html( rlx_signal_post_meta( get_the_ID(), 'rlx_display_date', get_the_date( 'Y.m.d' ) ) ); ?></p>
			<?php endif; ?>
			<div class="entry-content"><?php the_content(); ?></div>
			<p><a class="content-button" href="<?php echo esc_url( wp_get_referer() ? wp_get_referer() : home_url( '/' ) ); ?>"><?php esc_html_e( '返回', 'rlx-signal' ); ?></a></p>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
