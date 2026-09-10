<?php
/**
 * Content archive template.
 *
 * @package RLX_Signal
 */

get_header();
?>
<main id="main" class="inner-page">
	<header class="page-hero">
		<p><?php esc_html_e( 'Smart Hearing Group', 'rlx-signal' ); ?></p>
		<h1><?php echo esc_html( is_tax() ? single_term_title( '', false ) : post_type_archive_title( '', false ) ); ?></h1>
	</header>
	<div class="content-shell archive-shell">
		<?php if ( have_posts() ) : ?>
			<div class="archive-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php $image = rlx_signal_post_image_url( get_the_ID(), 'rlx_image' ); ?>
					<article <?php post_class( 'archive-card' ); ?>>
						<a href="<?php the_permalink(); ?>">
							<?php if ( $image ) : ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>" width="640" height="420">
							<?php endif; ?>
							<div>
								<?php if ( 'rlx_news' === get_post_type() ) : ?>
									<p class="archive-meta"><?php echo esc_html( rlx_signal_post_meta( get_the_ID(), 'rlx_display_date', get_the_date( 'Y.m.d' ) ) ); ?></p>
								<?php endif; ?>
								<h2><?php the_title(); ?></h2>
								<p><?php echo esc_html( rlx_signal_excerpt( get_the_ID() ) ); ?></p>
								<span><?php esc_html_e( '更多內容', 'rlx-signal' ); ?></span>
							</div>
						</a>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( '目前尚無內容。', 'rlx-signal' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
