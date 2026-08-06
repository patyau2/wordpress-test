<?php
/**
 * Theme setup and lightweight performance defaults.
 *
 * @package RLX_Signal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		),
		'rlx_email'    => array(
			'label'   => __( 'Email address', 'rlx-signal' ),
			'default' => 'info@smarthearing.com.tw',
		),
		'rlx_address'  => array(
			'label'   => __( '服務地區', 'rlx-signal' ),
			'default' => 'Taiwan',
		),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'rlx_contact',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'rlx_signal_customize_register' );

function rlx_signal_asset( $filename ) {
	return esc_url( get_template_directory_uri() . '/assets/images/' . ltrim( $filename, '/' ) );
}

function rlx_signal_whatsapp_url() {
	$number = get_theme_mod( 'rlx_whatsapp', '0800-580-590' );
	return 'https://wa.me/' . preg_replace( '/\D+/', '', $number );
}

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
	$schema      = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'MedicalBusiness',
		'name'        => '睿聲助聽器',
		'url'         => $url,
		'logo'        => get_template_directory_uri() . '/assets/images/smarthearing/logo.svg',
		'image'       => $image,
		'description' => $description,
		'telephone'   => '0800-580-590',
		'email'       => 'info@smarthearing.com.tw',
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
