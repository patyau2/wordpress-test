<?php
/**
 * WordPress content models used by the homepage.
 *
 * @package RLX_Signal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rlx_signal_content_labels( $singular, $plural ) {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'add_new_item'       => sprintf( __( 'Add new %s', 'rlx-signal' ), $singular ),
		'edit_item'          => sprintf( __( 'Edit %s', 'rlx-signal' ), $singular ),
		'new_item'           => sprintf( __( 'New %s', 'rlx-signal' ), $singular ),
		'view_item'          => sprintf( __( 'View %s', 'rlx-signal' ), $singular ),
		'search_items'       => sprintf( __( 'Search %s', 'rlx-signal' ), $plural ),
		'not_found'          => sprintf( __( 'No %s found.', 'rlx-signal' ), $plural ),
		'not_found_in_trash' => sprintf( __( 'No %s found in Trash.', 'rlx-signal' ), $plural ),
	);
}

function rlx_signal_register_content_types() {
	$types = array(
		'rlx_hero_slide' => array(
			'singular'    => __( '首頁輪播', 'rlx-signal' ),
			'plural'      => __( '首頁輪播', 'rlx-signal' ),
			'menu_icon'   => 'dashicons-images-alt2',
			'supports'    => array( 'title', 'page-attributes' ),
			'rewrite'     => false,
			'description' => __( 'Homepage hero carousel slides.', 'rlx-signal' ),
		),
		'rlx_news'       => array(
			'singular'    => __( '最新消息', 'rlx-signal' ),
			'plural'      => __( '最新消息', 'rlx-signal' ),
			'menu_icon'   => 'dashicons-megaphone',
			'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'rewrite'     => array( 'slug' => 'news' ),
			'has_archive' => 'news',
			'description' => __( 'News cards shown on the homepage.', 'rlx-signal' ),
		),
		'rlx_story'      => array(
			'singular'    => __( '聽力內容', 'rlx-signal' ),
			'plural'      => __( '聽力內容', 'rlx-signal' ),
			'menu_icon'   => 'dashicons-format-chat',
			'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'rewrite'     => array( 'slug' => 'hearing-content' ),
			'has_archive' => 'hearing-content',
			'description' => __( 'Stories and hearing knowledge cards shown on the homepage.', 'rlx-signal' ),
		),
		'rlx_brand'      => array(
			'singular'    => __( '品牌', 'rlx-signal' ),
			'plural'      => __( '品牌總覽', 'rlx-signal' ),
			'menu_icon'   => 'dashicons-products',
			'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'rewrite'     => array( 'slug' => 'hearing-aid-brands' ),
			'has_archive' => 'hearing-aid-brands',
			'description' => __( 'Brand cards shown on the homepage.', 'rlx-signal' ),
		),
		'rlx_promo'      => array(
			'singular'    => __( '宣傳圖卡', 'rlx-signal' ),
			'plural'      => __( '宣傳圖卡', 'rlx-signal' ),
			'menu_icon'   => 'dashicons-screenoptions',
			'supports'    => array( 'title', 'thumbnail', 'page-attributes' ),
			'rewrite'     => array( 'slug' => 'offers' ),
			'has_archive' => false,
			'description' => __( 'Linked image tiles shown below the brand section.', 'rlx-signal' ),
		),
	);

	foreach ( $types as $post_type => $config ) {
		register_post_type(
			$post_type,
			array(
				'labels'        => rlx_signal_content_labels( $config['singular'], $config['plural'] ),
				'description'   => $config['description'],
				'public'        => true,
				'show_ui'       => true,
				'show_in_menu'  => true,
				'show_in_rest'  => true,
				'menu_icon'     => $config['menu_icon'],
				'supports'      => $config['supports'],
				'has_archive'   => $config['has_archive'] ?? false,
				'hierarchical'  => false,
				'menu_position' => 22,
				'rewrite'       => $config['rewrite'],
			)
		);
	}

	register_post_type(
		'rlx_inquiry',
		array(
			'labels'       => rlx_signal_content_labels( __( '預約申請', 'rlx-signal' ), __( '預約申請', 'rlx-signal' ) ),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-calendar-alt',
			'supports'     => array( 'title', 'editor', 'custom-fields' ),
		)
	);

	register_taxonomy(
		'rlx_news_category',
		array( 'rlx_news' ),
		array(
			'labels'       => rlx_signal_content_labels( __( 'News category', 'rlx-signal' ), __( 'News categories', 'rlx-signal' ) ),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'news-category' ),
		)
	);

	register_taxonomy(
		'rlx_story_type',
		array( 'rlx_story' ),
		array(
			'labels'       => rlx_signal_content_labels( __( 'Hearing content type', 'rlx-signal' ), __( 'Hearing content types', 'rlx-signal' ) ),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => false,
		)
	);

	rlx_signal_register_post_meta();
}
add_action( 'init', 'rlx_signal_register_content_types', 0 );

function rlx_signal_meta_field_config() {
	return array(
		'rlx_display_date' => array(
			'label'       => __( 'Display date', 'rlx-signal' ),
			'description' => __( 'Shown on news cards, for example 2026.06.30.', 'rlx-signal' ),
			'type'        => 'text',
		),
		'rlx_image'        => array(
			'label'       => __( 'Image URL or theme asset filename', 'rlx-signal' ),
			'description' => __( 'Use a Media Library URL, or a file from assets/images/smarthearing such as news-hear-more.webp. Featured images take priority.', 'rlx-signal' ),
			'type'        => 'text',
		),
		'rlx_mobile_image' => array(
			'label'       => __( 'Mobile image URL or theme asset filename', 'rlx-signal' ),
			'description' => __( 'Optional hero image for small screens.', 'rlx-signal' ),
			'type'        => 'text',
		),
		'rlx_link_url'     => array(
			'label'       => __( 'Link URL', 'rlx-signal' ),
			'description' => __( 'Optional. Leave blank to use the WordPress permalink where one exists.', 'rlx-signal' ),
			'type'        => 'url',
		),
		'rlx_link_label'   => array(
			'label'       => __( 'Link label', 'rlx-signal' ),
			'description' => __( 'Optional button/link text.', 'rlx-signal' ),
			'type'        => 'text',
		),
	);
}

function rlx_signal_fields_for_post_type( $post_type ) {
	$fields = array(
		'rlx_hero_slide' => array( 'rlx_image', 'rlx_mobile_image', 'rlx_link_url' ),
		'rlx_news'       => array( 'rlx_display_date', 'rlx_image', 'rlx_link_url', 'rlx_link_label' ),
		'rlx_story'      => array( 'rlx_image', 'rlx_link_url', 'rlx_link_label' ),
		'rlx_brand'      => array( 'rlx_image', 'rlx_link_url', 'rlx_link_label' ),
		'rlx_promo'      => array( 'rlx_image', 'rlx_link_url' ),
	);

	return $fields[ $post_type ] ?? array();
}

function rlx_signal_register_post_meta() {
	$config = rlx_signal_meta_field_config();

	foreach ( array( 'rlx_hero_slide', 'rlx_news', 'rlx_story', 'rlx_brand', 'rlx_promo' ) as $post_type ) {
		foreach ( rlx_signal_fields_for_post_type( $post_type ) as $field ) {
			register_post_meta(
				$post_type,
				$field,
				array(
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'url' === $config[ $field ]['type'] ? 'rlx_signal_sanitize_url_or_anchor' : 'sanitize_text_field',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
}

function rlx_signal_add_meta_boxes() {
	foreach ( array( 'rlx_hero_slide', 'rlx_news', 'rlx_story', 'rlx_brand', 'rlx_promo' ) as $post_type ) {
		add_meta_box(
			'rlx_signal_homepage_fields',
			__( 'Homepage display fields', 'rlx-signal' ),
			'rlx_signal_render_meta_box',
			$post_type,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'rlx_signal_add_meta_boxes' );

function rlx_signal_render_meta_box( $post ) {
	$config = rlx_signal_meta_field_config();
	wp_nonce_field( 'rlx_signal_save_meta', 'rlx_signal_meta_nonce' );

	foreach ( rlx_signal_fields_for_post_type( $post->post_type ) as $field ) {
		$value = get_post_meta( $post->ID, $field, true );
		?>
		<p>
			<label for="<?php echo esc_attr( $field ); ?>"><strong><?php echo esc_html( $config[ $field ]['label'] ); ?></strong></label>
			<input
				id="<?php echo esc_attr( $field ); ?>"
				name="<?php echo esc_attr( $field ); ?>"
				type="<?php echo 'url' === $config[ $field ]['type'] ? 'url' : 'text'; ?>"
				value="<?php echo esc_attr( $value ); ?>"
				class="widefat"
			>
			<span class="description"><?php echo esc_html( $config[ $field ]['description'] ); ?></span>
		</p>
		<?php
	}
}

function rlx_signal_save_meta( $post_id ) {
	if (
		! isset( $_POST['rlx_signal_meta_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rlx_signal_meta_nonce'] ) ), 'rlx_signal_save_meta' ) ||
		( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
		! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	$post_type = get_post_type( $post_id );
	$config    = rlx_signal_meta_field_config();

	foreach ( rlx_signal_fields_for_post_type( $post_type ) as $field ) {
		$raw   = isset( $_POST[ $field ] ) ? wp_unslash( $_POST[ $field ] ) : '';
		$value = 'url' === $config[ $field ]['type'] ? rlx_signal_sanitize_url_or_anchor( $raw ) : sanitize_text_field( $raw );

		if ( '' === $value ) {
			delete_post_meta( $post_id, $field );
		} else {
			update_post_meta( $post_id, $field, $value );
		}
	}
}
add_action( 'save_post', 'rlx_signal_save_meta' );
