<?php
/**
 * Template helpers for database-backed homepage sections.
 *
 * @package RLX_Signal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rlx_signal_asset( $filename ) {
	return esc_url( get_template_directory_uri() . '/assets/images/' . ltrim( $filename, '/' ) );
}

function rlx_signal_sanitize_url_or_anchor( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value || str_starts_with( $value, '#' ) || str_starts_with( $value, '/' ) ) {
		return sanitize_text_field( $value );
	}

	return esc_url_raw( $value );
}

function rlx_signal_get_phone() {
	return get_theme_mod( 'rlx_whatsapp', '0800-580-590' );
}

function rlx_signal_get_email() {
	return get_theme_mod( 'rlx_email', 'info@smarthearing.com.tw' );
}

function rlx_signal_phone_href() {
	return 'tel:' . preg_replace( '/\D+/', '', rlx_signal_get_phone() );
}

function rlx_signal_whatsapp_url() {
	return 'https://wa.me/' . preg_replace( '/\D+/', '', rlx_signal_get_phone() );
}

function rlx_signal_home_mod( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

function rlx_signal_page_url( $slug, $fallback = '/' ) {
	$page = get_page_by_path( $slug );

	return $page ? get_permalink( $page ) : home_url( $fallback );
}

function rlx_signal_archive_url( $post_type, $fallback = '/' ) {
	$url = get_post_type_archive_link( $post_type );

	return $url ? $url : home_url( $fallback );
}

function rlx_signal_post_meta( $post_id, $key, $default = '' ) {
	$value = get_post_meta( $post_id, $key, true );

	return '' === $value ? $default : $value;
}

function rlx_signal_image_url( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	if ( preg_match( '#^https?://#i', $value ) || str_starts_with( $value, '/' ) ) {
		return esc_url( $value );
	}

	return rlx_signal_asset( 'smarthearing/' . $value );
}

function rlx_signal_post_image_url( $post_id, $meta_key = 'rlx_image', $fallback = '' ) {
	$thumbnail = get_the_post_thumbnail_url( $post_id, 'full' );

	if ( $thumbnail ) {
		return esc_url( $thumbnail );
	}

	$image = rlx_signal_post_meta( $post_id, $meta_key, $fallback );

	return rlx_signal_image_url( $image );
}

function rlx_signal_post_link( $post_id, $default = '' ) {
	$url = rlx_signal_post_meta( $post_id, 'rlx_link_url', '' );

	if ( '' !== $url ) {
		return esc_url( $url );
	}

	return esc_url( $default ? $default : get_permalink( $post_id ) );
}

function rlx_signal_excerpt( $post_id ) {
	$excerpt = get_the_excerpt( $post_id );

	if ( '' !== trim( $excerpt ) ) {
		return $excerpt;
	}

	return wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), 35 );
}

function rlx_signal_section_posts( $post_type, $limit = 3, $args = array() ) {
	return get_posts(
		array_merge(
			array(
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'posts_per_page'   => $limit,
				'orderby'          => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
				'suppress_filters' => false,
			),
			$args
		)
	);
}

function rlx_signal_story_posts( $term_slug, $limit = 2 ) {
	return rlx_signal_section_posts(
		'rlx_story',
		$limit,
		array(
			'tax_query' => array(
				array(
					'taxonomy' => 'rlx_story_type',
					'field'    => 'slug',
					'terms'    => $term_slug,
				),
			),
		)
	);
}

function rlx_signal_first_term_name( $post_id, $taxonomy ) {
	$terms = get_the_terms( $post_id, $taxonomy );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}

	return $terms[0]->name;
}
