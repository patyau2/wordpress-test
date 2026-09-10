<?php
/**
 * Standard page template.
 *
 * @package RLX_Signal
 */

get_header();
?>
<main id="main" class="inner-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<header class="page-hero">
			<p><?php esc_html_e( 'Smart Hearing Group', 'rlx-signal' ); ?></p>
			<h1><?php the_title(); ?></h1>
		</header>
		<article <?php post_class( 'content-shell page-content' ); ?>>
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
