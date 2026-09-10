<?php
/**
 * Theme setup and lightweight performance defaults.
 *
 * @package RLX_Signal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/content-models.php';
require_once get_template_directory() . '/inc/seed.php';
require_once get_template_directory() . '/inc/forms.php';

function rlx_signal_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 48,
			'width'       => 148,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'rlx-signal' ),
			'footer'  => __( 'Footer navigation', 'rlx-signal' ),
		)
	);
}
add_action( 'after_setup_theme', 'rlx_signal_setup' );

function rlx_signal_assets() {
	$theme = wp_get_theme();
	wp_enqueue_style(
		'rlx-signal-fonts',
		'https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;600;700&family=Noto+Serif+TC:wght@600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'rlx-signal',
		get_stylesheet_uri(),
		array( 'rlx-signal-fonts' ),
		$theme->get( 'Version' )
	);
	wp_enqueue_script(
		'rlx-signal',
		get_template_directory_uri() . '/assets/js/site.js',
		array(),
		$theme->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'rlx_signal_assets' );

function rlx_signal_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'rlx_signal_resource_hints', 10, 2 );

function rlx_signal_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'rlx_contact',
		array(
			'title'    => __( '睿聲聯絡資料', 'rlx-signal' ),
			'priority' => 30,
		)
	);

	$fields = array(
		'rlx_whatsapp' => array(
			'label'   => __( '免付費專線', 'rlx-signal' ),
			'default' => '0800-580-590',
			'type'    => 'text',
		),
		'rlx_email'    => array(
			'label'   => __( 'Email address', 'rlx-signal' ),
			'default' => 'info@smarthearing.com.tw',
			'type'    => 'email',
		),
		'rlx_address'  => array(
			'label'   => __( '服務地區', 'rlx-signal' ),
			'default' => 'Taiwan',
			'type'    => 'text',
		),
		'rlx_facebook_url' => array(
			'label'   => __( 'Facebook URL', 'rlx-signal' ),
			'default' => 'https://www.facebook.com/Smarthearingaids/',
			'type'    => 'url',
		),
		'rlx_line_url' => array(
			'label'   => __( 'LINE URL', 'rlx-signal' ),
			'default' => 'https://lin.ee/DqE9QxN',
			'type'    => 'url',
		),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'url' === $field['type'] ? 'rlx_signal_sanitize_url_or_anchor' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'rlx_contact',
				'type'    => $field['type'],
			)
		);
	}

	$wp_customize->add_section(
		'rlx_home_content',
		array(
			'title'    => __( '睿聲首頁內容', 'rlx-signal' ),
			'priority' => 31,
		)
	);

	$home_fields = array(
		'rlx_news_eyebrow' => array(
			'label'   => __( 'News eyebrow', 'rlx-signal' ),
			'default' => 'News',
			'type'    => 'text',
		),
		'rlx_news_heading' => array(
			'label'   => __( 'News heading', 'rlx-signal' ),
			'default' => '睿聲快訊',
			'type'    => 'text',
		),
		'rlx_about_eyebrow' => array(
			'label'   => __( 'About eyebrow', 'rlx-signal' ),
			'default' => 'Hearing is Our Concern',
			'type'    => 'text',
		),
		'rlx_about_heading' => array(
			'label'   => __( 'About heading', 'rlx-signal' ),
			'default' => '助聽器產品和解決顧客聽力問題的領導者',
			'type'    => 'text',
		),
		'rlx_about_body' => array(
			'label'   => __( 'About body', 'rlx-signal' ),
			'default' => '提供在地化服務，並透過精密的檢測設備、專業聽力師及選配人員，導入歐美多品牌高品質助聽器產品，讓您買的放心，聽的安心。',
			'type'    => 'textarea',
		),
		'rlx_about_button_title' => array(
			'label'   => __( 'Reservation button title', 'rlx-signal' ),
			'default' => '立即預約 聆聽美好',
			'type'    => 'text',
		),
		'rlx_about_button_subtitle' => array(
			'label'   => __( 'Reservation button subtitle', 'rlx-signal' ),
			'default' => 'Reservation',
			'type'    => 'text',
		),
		'rlx_about_button_url' => array(
			'label'   => __( 'Reservation button URL', 'rlx-signal' ),
			'default' => '/appointment/',
			'type'    => 'url',
		),
		'rlx_brands_eyebrow' => array(
			'label'   => __( 'Brands eyebrow', 'rlx-signal' ),
			'default' => 'Collection',
			'type'    => 'text',
		),
		'rlx_brands_heading' => array(
			'label'   => __( 'Brands heading', 'rlx-signal' ),
			'default' => '嚴選優質品牌',
			'type'    => 'text',
		),
		'rlx_footer_legal' => array(
			'label'   => __( 'Footer legal text', 'rlx-signal' ),
			'default' => "衛部醫器輸壹字第018320號\n衛部醫器輸壹字第020282號\n衛署醫器輸壹字第010085號",
			'type'    => 'textarea',
		),
		'rlx_footer_copyright' => array(
			'label'   => __( 'Footer copyright', 'rlx-signal' ),
			'default' => 'Copyright © 睿聲科技股份有限公司 Smart Hearing Group 版權所有　衛部醫器輸壹字第020499號，北市衛器廣字第108090250號',
			'type'    => 'textarea',
		),
	);

	foreach ( $home_fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'textarea' === $field['type'] ? 'sanitize_textarea_field' : ( 'url' === $field['type'] ? 'rlx_signal_sanitize_url_or_anchor' : 'sanitize_text_field' ),
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'rlx_home_content',
				'type'    => $field['type'],
			)
		);
	}
}
add_action( 'customize_register', 'rlx_signal_customize_register' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

function rlx_signal_home_meta() {
	if ( ! is_front_page() ) {
		return;
	}

	$title       = '睿聲助聽器 | 專業聽力服務與助聽器選配';
	$description = '睿聲助聽器提供專業聽力檢查、助聽器選配、政府補助諮詢與在地門市服務。';
	$image       = get_template_directory_uri() . '/assets/images/smarthearing/hero.png';
	$url         = home_url( '/' );
	$address     = get_theme_mod( 'rlx_address', 'Taiwan' );
	$phone       = rlx_signal_get_phone();
	$email       = rlx_signal_get_email();
	$schema      = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'MedicalBusiness',
		'name'        => '睿聲助聽器',
		'url'         => $url,
		'logo'        => get_template_directory_uri() . '/assets/images/smarthearing/logo.svg',
		'image'       => $image,
		'description' => $description,
		'telephone'   => $phone,
		'email'       => $email,
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address,
			'addressLocality' => 'Taiwan',
			'addressCountry'  => 'TW',
		),
		'areaServed'  => 'Taiwan',
	);
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<link rel="canonical" href="<?php echo esc_url( $url ); ?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
	<?php
}
add_action( 'wp_head', 'rlx_signal_home_meta', 2 );

function rlx_signal_document_title( $title ) {
	if ( is_front_page() ) {
		return '睿聲助聽器 | 專業聽力服務與助聽器選配';
	}

	return $title;
}
add_filter( 'pre_get_document_title', 'rlx_signal_document_title' );

function rlx_signal_filter_story_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'rlx_story' ) ) {
		return;
	}

	$type = isset( $_GET['content_type'] ) ? sanitize_key( wp_unslash( $_GET['content_type'] ) ) : '';
	if ( in_array( $type, array( 'stories', 'articles' ), true ) ) {
		$query->set(
			'tax_query',
			array(
				array(
					'taxonomy' => 'rlx_story_type',
					'field'    => 'slug',
					'terms'    => $type,
				),
			)
		);
	}
}
add_action( 'pre_get_posts', 'rlx_signal_filter_story_archive' );
