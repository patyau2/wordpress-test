<?php
/**
 * First-run content seed for the homepage.
 *
 * @package RLX_Signal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RLX_SIGNAL_SEED_VERSION = 3;

function rlx_signal_seed_default_theme_mods() {
	$defaults = array(
		'rlx_whatsapp'              => '0800-580-590',
		'rlx_email'                 => 'info@smarthearing.com.tw',
		'rlx_address'               => 'Taiwan',
		'rlx_facebook_url'          => 'https://www.facebook.com/Smarthearingaids/',
		'rlx_line_url'              => 'https://lin.ee/DqE9QxN',
		'rlx_news_eyebrow'          => 'News',
		'rlx_news_heading'          => '睿聲快訊',
		'rlx_about_eyebrow'         => 'Hearing is Our Concern',
		'rlx_about_heading'         => '助聽器產品和解決顧客聽力問題的領導者',
		'rlx_about_body'            => '提供在地化服務，並透過精密的檢測設備、專業聽力師及選配人員，導入歐美多品牌高品質助聽器產品，讓您買的放心，聽的安心。',
		'rlx_about_button_title'    => '立即預約 聆聽美好',
		'rlx_about_button_subtitle' => 'Reservation',
		'rlx_about_button_url'      => '/appointment/',
		'rlx_brands_eyebrow'        => 'Collection',
		'rlx_brands_heading'        => '嚴選優質品牌',
		'rlx_footer_legal'          => "衛部醫器輸壹字第018320號\n衛部醫器輸壹字第020282號\n衛署醫器輸壹字第010085號",
		'rlx_footer_copyright'      => 'Copyright © 睿聲科技股份有限公司 Smart Hearing Group 版權所有　衛部醫器輸壹字第020499號，北市衛器廣字第108090250號',
	);

	foreach ( $defaults as $key => $value ) {
		if ( false === get_theme_mod( $key, false ) ) {
			set_theme_mod( $key, $value );
		}
	}
}

function rlx_signal_seed_page( $slug, $title, $content ) {
	$page = get_page_by_path( $slug );

	if ( $page ) {
		if ( 'publish' !== $page->post_status ) {
			wp_update_post(
				array(
					'ID'           => $page->ID,
					'post_title'   => $title,
					'post_content' => $content,
					'post_status'  => 'publish',
				)
			);
		}
		return (int) $page->ID;
	}

	return (int) wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => 'publish',
		)
	);
}

function rlx_signal_migrate_placeholder_link( $post_type, $slug, $url = '' ) {
	$posts = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => $post_type,
			'post_status'    => 'any',
			'posts_per_page' => 1,
		)
	);

	if ( ! $posts ) {
		return;
	}

	$current = get_post_meta( $posts[0]->ID, 'rlx_link_url', true );
	if ( '' === $current || '#' === $current ) {
		if ( '' === $url ) {
			delete_post_meta( $posts[0]->ID, 'rlx_link_url' );
		} else {
			update_post_meta( $posts[0]->ID, 'rlx_link_url', $url );
		}
	}
}

function rlx_signal_seed_term( $taxonomy, $name, $slug ) {
	$term = term_exists( $slug, $taxonomy );

	if ( ! $term ) {
		$term = wp_insert_term(
			$name,
			$taxonomy,
			array(
				'slug' => $slug,
			)
		);
	}

	if ( is_wp_error( $term ) ) {
		return 0;
	}

	return is_array( $term ) ? (int) $term['term_id'] : (int) $term;
}

function rlx_signal_seed_post( $post_type, $slug, $title, $content = '', $excerpt = '', $menu_order = 0, $meta = array(), $taxonomies = array(), $date = '' ) {
	$existing = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => $post_type,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $existing ) {
		$post_id = (int) $existing[0];
	} else {
		$post_id = wp_insert_post(
			array(
				'post_type'    => $post_type,
				'post_name'    => $slug,
				'post_title'   => $title,
				'post_content' => $content,
				'post_excerpt' => $excerpt,
				'post_status'  => 'publish',
				'menu_order'   => $menu_order,
				'post_date'    => $date ? $date : current_time( 'mysql' ),
			),
			true
		);
	}

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return 0;
	}

	foreach ( $meta as $key => $value ) {
		if ( '' !== $value && '' === get_post_meta( $post_id, $key, true ) ) {
			update_post_meta( $post_id, $key, $value );
		}
	}

	foreach ( $taxonomies as $taxonomy => $term_ids ) {
		$term_ids = array_filter( array_map( 'intval', (array) $term_ids ) );
		if ( $term_ids ) {
			wp_set_object_terms( $post_id, $term_ids, $taxonomy, false );
		}
	}

	return (int) $post_id;
}

function rlx_signal_seed_default_content() {
	$seeded_version = (int) get_option( 'rlx_signal_seed_version', 0 );

	if ( $seeded_version >= RLX_SIGNAL_SEED_VERSION ) {
		return;
	}

	if ( ! post_type_exists( 'rlx_news' ) ) {
		rlx_signal_register_content_types();
	}

	$already_has_news = get_posts(
		array(
			'post_type'      => 'rlx_news',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	rlx_signal_seed_default_theme_mods();

	$pages = array(
		array( 'about', '關於我們', '<p>睿聲助聽器以專業聽力評估、助聽器選配與在地化服務，協助每一位聽友找回清楚自在的溝通。</p><h2>專業服務內容</h2><p>由專業人員提供聽力檢查、產品諮詢、選配調整、保養維修與政府補助申請說明。</p>' ),
		array( 'appointment', '線上預約', '<p>請填寫以下資料，門市服務人員將儘快與您聯絡並確認預約時間。</p>[rlx_reservation_form]' ),
		array( 'stores', '門市據點', '<p>睿聲在全台提供在地化聽力服務。來店前請先致電 0800-580-590 或使用線上預約，我們會協助安排鄰近門市。</p><p><a class="content-button" href="/appointment/">立即預約門市服務</a></p>' ),
		array( 'government-subsidy', '政府補助', '<p>助聽器補助資格與申請方式會依身分、地區及現行規定而異。睿聲可協助您了解所需文件與申請流程。</p><p><a class="content-button" href="/appointment/">預約補助諮詢</a></p>' ),
		array( 'privacy-policy', '隱私權政策', '<p>我們僅在提供預約、諮詢與客戶服務所需範圍內蒐集個人資料，並依適用法令妥善保管。未經同意，不會將資料提供予無關第三方。</p><h2>聯絡我們</h2><p>如需查詢、更正或刪除個人資料，請聯絡 info@smarthearing.com.tw。</p>' ),
		array( 'sitemap', '網站地圖', '[rlx_sitemap]' ),
		array( 'subscription-plan', '助聽器訂閱制方案', '<p>以彈性的方案取得助聽器與持續調整服務。實際產品、費用與方案內容由門市依聽力需求說明。</p><p><a class="content-button" href="/appointment/">洽詢訂閱方案</a></p>' ),
		array( 'online-hearing-test', '線上聽力測試', '<p>簡易線上測試可協助您留意聽力變化，但不能取代專業聽力檢查。若日常對話經常聽不清楚，建議安排完整評估。</p><p><a class="content-button" href="/appointment/">預約專業聽力檢查</a></p>' ),
	);

	foreach ( $pages as $page ) {
		rlx_signal_seed_page( $page[0], $page[1], $page[2] );
	}

	if ( in_array( get_theme_mod( 'rlx_facebook_url', '' ), array( '', '#' ), true ) ) {
		set_theme_mod( 'rlx_facebook_url', 'https://www.facebook.com/Smarthearingaids/' );
	}
	if ( in_array( get_theme_mod( 'rlx_line_url', '' ), array( '', '#' ), true ) ) {
		set_theme_mod( 'rlx_line_url', 'https://lin.ee/DqE9QxN' );
	}
	if ( in_array( get_theme_mod( 'rlx_about_button_url', '' ), array( '', '#contact' ), true ) ) {
		set_theme_mod( 'rlx_about_button_url', '/appointment/' );
	}

	foreach ( array( 'resound-hearing-aids', 'interton-hearing-aids', 'audibel-hearing-aids', 'phonak-hearing-aids' ) as $brand_slug ) {
		rlx_signal_migrate_placeholder_link( 'rlx_brand', $brand_slug );
	}
	rlx_signal_migrate_placeholder_link( 'rlx_promo', 'store-map', '/stores/' );
	rlx_signal_migrate_placeholder_link( 'rlx_promo', 'subscription-plan', '/subscription-plan/' );
	rlx_signal_migrate_placeholder_link( 'rlx_promo', 'online-hearing-test', '/online-hearing-test/' );

	if ( $already_has_news ) {
		update_option( 'rlx_signal_seed_version', RLX_SIGNAL_SEED_VERSION );
		flush_rewrite_rules( false );
		return;
	}

	$seminar_term = rlx_signal_seed_term( 'rlx_news_category', '學術研討會', 'seminars' );
	$news_term    = rlx_signal_seed_term( 'rlx_news_category', '新聞快訊', 'news' );
	$stories_term = rlx_signal_seed_term( 'rlx_story_type', '聽友分享', 'stories' );
	$articles_term = rlx_signal_seed_term( 'rlx_story_type', '聽力小百科', 'articles' );

	rlx_signal_seed_post(
		'rlx_hero_slide',
		'latest-hearing-event',
		'睿聲助聽器最新活動',
		'',
		'',
		1,
		array(
			'rlx_image'        => 'hero-active.webp',
			'rlx_mobile_image' => 'hero-active-mobile.jpg',
			'rlx_link_url'     => '#products',
		)
	);

	rlx_signal_seed_post(
		'rlx_hero_slide',
		'hearing-care-opening',
		'專業聽力服務與助聽器選配',
		'',
		'',
		2,
		array(
			'rlx_image'        => 'hero-opening.webp',
			'rlx_mobile_image' => 'hero-opening-mobile.webp',
			'rlx_link_url'     => '#about',
		)
	);

	rlx_signal_seed_post(
		'rlx_news',
		'hear-more-2026',
		'Hear More 2026 - 接軌國際，聽見自信',
		'睿聲助聽器持續引進國際聽力照護資訊，協助使用者以更自在的方式回到清楚溝通。',
		'',
		1,
		array(
			'rlx_display_date' => '2026.06.30',
			'rlx_image'        => 'news-hear-more.webp',
		),
		array( 'rlx_news_category' => $seminar_term ),
		'2026-06-30 09:00:00'
	);

	rlx_signal_seed_post(
		'rlx_news',
		'dragon-boat-holiday',
		'端午連假｜睿聲門市公告',
		'端午連假期間門市服務時間依各區公告調整，建議來店前先致電確認。',
		'',
		2,
		array(
			'rlx_display_date' => '2026.06.17',
			'rlx_image'        => 'news-holiday.webp',
		),
		array( 'rlx_news_category' => $news_term ),
		'2026-06-17 09:00:00'
	);

	rlx_signal_seed_post(
		'rlx_news',
		'subsidy-information',
		'補助資訊｜睿聲助聽器',
		'整理助聽器相關補助資訊，協助需要者了解申請流程與準備文件。',
		'',
		3,
		array(
			'rlx_display_date' => '2026.05.29',
			'rlx_image'        => 'news-subsidy.jpg',
		),
		array( 'rlx_news_category' => $news_term ),
		'2026-05-29 09:00:00'
	);

	rlx_signal_seed_post(
		'rlx_story',
		'retired-director-hearing-crisis',
		'退休主任的無聲危機，積極面對突發耳聾 - 新營門市 吳委員',
		'六月初，鄰近下班的傍晚。門市大門被匆忙推開，家人神情慌張，專業團隊立即提供聽力評估與協助。',
		'六月初，鄰近下班的傍晚。門市大門被匆忙推開，家人神情慌張，專業團隊立即提供聽力評估與協助。',
		1,
		array(
			'rlx_image'      => 'story-1.png',
			'rlx_link_label' => '更多內容',
		),
		array( 'rlx_story_type' => $stories_term )
	);

	rlx_signal_seed_post(
		'rlx_story',
		'confidence-after-hearing-loss',
		'疫情導致聽損，陽光女孩重新掌握自信！ - 中山門市 黃經理',
		'面對突如其來的高頻聽力損失，透過專業選配與調整，重新找回清楚溝通的自在生活。',
		'面對突如其來的高頻聽力損失，透過專業選配與調整，重新找回清楚溝通的自在生活。',
		2,
		array(
			'rlx_image'      => 'story-2.jpg',
			'rlx_link_label' => '更多內容',
		),
		array( 'rlx_story_type' => $stories_term )
	);

	rlx_signal_seed_post(
		'rlx_story',
		'hearing-aid-care-guide',
		'助聽器正確使用與保養全攻略',
		'認識助聽器的功能、清潔保養技巧，以及配戴初期常見問題，讓聽力不卡卡。',
		'認識助聽器的功能、清潔保養技巧，以及配戴初期常見問題，讓聽力不卡卡。',
		3,
		array(
			'rlx_image'      => 'story-3.png',
			'rlx_link_label' => '更多內容',
		),
		array( 'rlx_story_type' => $articles_term )
	);

	rlx_signal_seed_post(
		'rlx_story',
		'home-hearing-screening',
		'如何在家自我聽力篩檢？',
		'及早察覺聽力變化，並由專業人員進一步評估，是維持生活品質的重要一步。',
		'及早察覺聽力變化，並由專業人員進一步評估，是維持生活品質的重要一步。',
		4,
		array(
			'rlx_image'      => 'story-4.png',
			'rlx_link_label' => '更多內容',
		),
		array( 'rlx_story_type' => $articles_term )
	);

	$brands = array(
		array( 'resound-hearing-aids', 'ReSound 助聽器', 'brand-resound.png', 1 ),
		array( 'interton-hearing-aids', 'Interton 助聽器', 'brand-interton.png', 2 ),
		array( 'audibel-hearing-aids', '美國 AUDIBEL 助聽器', 'brand-audibel.png', 3 ),
		array( 'phonak-hearing-aids', '瑞士 PHONAK 助聽器', 'brand-phonak.jpg', 4 ),
	);

	foreach ( $brands as $brand ) {
		rlx_signal_seed_post(
			'rlx_brand',
			$brand[0],
			$brand[1],
			'',
			'',
			$brand[3],
			array(
				'rlx_image'      => $brand[2],
				'rlx_link_label' => '系列商品',
			)
		);
	}

	$promos = array(
		array( 'store-map', '睿聲門市地圖', 'promo-map.png', '/stores/', 1 ),
		array( 'subscription-plan', '睿聲助聽器訂閱制方案', 'promo-subscription.png', '/subscription-plan/', 2 ),
		array( 'online-hearing-test', '線上聽力測試', 'promo-test.png', '/online-hearing-test/', 3 ),
	);

	foreach ( $promos as $promo ) {
		rlx_signal_seed_post(
			'rlx_promo',
			$promo[0],
			$promo[1],
			'',
			'',
			$promo[4],
			array(
				'rlx_image'    => $promo[2],
				'rlx_link_url' => $promo[3],
			)
		);
	}

	update_option( 'rlx_signal_seed_version', RLX_SIGNAL_SEED_VERSION );
	flush_rewrite_rules( false );
}
add_action( 'after_switch_theme', 'rlx_signal_seed_default_content' );
add_action( 'init', 'rlx_signal_seed_default_content', 20 );
