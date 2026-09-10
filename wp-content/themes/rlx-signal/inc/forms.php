<?php
/**
 * Front-end forms and database persistence.
 *
 * @package RLX_Signal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rlx_signal_reservation_form() {
	$status = isset( $_GET['reservation'] ) ? sanitize_key( wp_unslash( $_GET['reservation'] ) ) : '';

	ob_start();
	?>
	<?php if ( 'success' === $status ) : ?>
		<div class="form-notice is-success" role="status">預約資料已送出，我們會儘快與您聯絡。</div>
	<?php elseif ( 'error' === $status ) : ?>
		<div class="form-notice is-error" role="alert">資料未能送出，請確認必填欄位後再試一次。</div>
	<?php endif; ?>
	<form class="reservation-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
		<input type="hidden" name="action" value="rlx_signal_reservation">
		<?php wp_nonce_field( 'rlx_signal_reservation', 'rlx_signal_reservation_nonce' ); ?>
		<p>
			<label for="reservation-name">姓名 <span aria-hidden="true">*</span></label>
			<input id="reservation-name" name="name" type="text" autocomplete="name" required>
		</p>
		<p>
			<label for="reservation-phone">聯絡電話 <span aria-hidden="true">*</span></label>
			<input id="reservation-phone" name="phone" type="tel" autocomplete="tel" inputmode="tel" required>
		</p>
		<p>
			<label for="reservation-email">Email</label>
			<input id="reservation-email" name="email" type="email" autocomplete="email">
		</p>
		<p>
			<label for="reservation-location">希望服務地區</label>
			<input id="reservation-location" name="location" type="text" autocomplete="address-level1">
		</p>
		<p class="form-wide">
			<label for="reservation-message">諮詢內容</label>
			<textarea id="reservation-message" name="message" rows="5"></textarea>
		</p>
		<label class="form-consent form-wide">
			<input name="consent" type="checkbox" value="1" required>
			<span>我同意依隱私權政策使用上述資料，以便聯絡及安排服務。</span>
		</label>
		<p class="form-wide"><button type="submit">送出預約</button></p>
	</form>
	<?php

	return ob_get_clean();
}
add_shortcode( 'rlx_reservation_form', 'rlx_signal_reservation_form' );

function rlx_signal_handle_reservation() {
	$nonce   = isset( $_POST['rlx_signal_reservation_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['rlx_signal_reservation_nonce'] ) ) : '';
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$location = isset( $_POST['location'] ) ? sanitize_text_field( wp_unslash( $_POST['location'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$consent = isset( $_POST['consent'] ) && '1' === $_POST['consent'];
	$redirect = rlx_signal_page_url( 'appointment', '/appointment/' );

	if ( ! wp_verify_nonce( $nonce, 'rlx_signal_reservation' ) || '' === $name || '' === $phone || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'reservation', 'error', $redirect ) );
		exit;
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'rlx_inquiry',
			'post_status'  => 'private',
			'post_title'   => sprintf( '%s - %s', $name, current_time( 'Y-m-d H:i' ) ),
			'post_content' => $message,
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		wp_safe_redirect( add_query_arg( 'reservation', 'error', $redirect ) );
		exit;
	}

	update_post_meta( $post_id, 'rlx_name', $name );
	update_post_meta( $post_id, 'rlx_phone', $phone );
	update_post_meta( $post_id, 'rlx_email', $email );
	update_post_meta( $post_id, 'rlx_location', $location );
	wp_safe_redirect( add_query_arg( 'reservation', 'success', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_rlx_signal_reservation', 'rlx_signal_handle_reservation' );
add_action( 'admin_post_rlx_signal_reservation', 'rlx_signal_handle_reservation' );

function rlx_signal_sitemap_shortcode() {
	$links = array(
		'關於我們' => rlx_signal_page_url( 'about', '/about/' ),
		'聽力小百科' => rlx_signal_archive_url( 'rlx_story', '/hearing-content/' ),
		'產品介紹' => rlx_signal_archive_url( 'rlx_brand', '/hearing-aid-brands/' ),
		'最新消息' => rlx_signal_archive_url( 'rlx_news', '/news/' ),
		'門市據點' => rlx_signal_page_url( 'stores', '/stores/' ),
		'政府補助' => rlx_signal_page_url( 'government-subsidy', '/government-subsidy/' ),
		'線上預約' => rlx_signal_page_url( 'appointment', '/appointment/' ),
	);
	$html = '<ul class="sitemap-list">';
	foreach ( $links as $label => $url ) {
		$html .= sprintf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}

	return $html . '</ul>';
}
add_shortcode( 'rlx_sitemap', 'rlx_signal_sitemap_shortcode' );
