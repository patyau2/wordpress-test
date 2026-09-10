<?php
/**
 * Site header.
 *
 * @package RLX_Signal
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#bf002b">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( '跳至主要內容', 'rlx-signal' ); ?></a>

<header class="site-header" data-header>
	<div class="header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="睿聲助聽器首頁">
			<?php
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			if ( $custom_logo_id ) {
				echo wp_get_attachment_image( $custom_logo_id, 'full', false, array( 'alt' => get_bloginfo( 'name' ) ) );
			} else {
				?>
				<img src="<?php echo rlx_signal_asset( 'smarthearing/logo.svg' ); ?>" alt="睿聲助聽器 Smart Hearing Group" width="230" height="64">
				<?php
			}
			?>
		</a>

		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
			<span><?php esc_html_e( '選單', 'rlx-signal' ); ?></span>
			<i aria-hidden="true"></i>
		</button>

		<nav id="primary-menu" class="primary-nav" aria-label="主要導覽">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'nav-list',
						'depth'          => 2,
						'fallback_cb'    => false,
					)
				);
			} else {
				?>
				<ul class="nav-list">
					<li class="menu-item-has-children"><a href="<?php echo esc_url( rlx_signal_page_url( 'about', '/about/' ) ); ?>">關於我們</a><ul class="sub-menu"><li><a href="<?php echo esc_url( rlx_signal_page_url( 'about', '/about/' ) ); ?>">服務內容</a></li><li><a href="<?php echo esc_url( rlx_signal_page_url( 'about', '/about/' ) . '#services' ); ?>">服務流程</a></li></ul></li>
					<li class="menu-item-has-children"><a href="<?php echo esc_url( rlx_signal_archive_url( 'rlx_story', '/hearing-content/' ) ); ?>">聽力小百科</a><ul class="sub-menu"><li><a href="<?php echo esc_url( add_query_arg( 'content_type', 'stories', rlx_signal_archive_url( 'rlx_story', '/hearing-content/' ) ) ); ?>">聽友分享</a></li><li><a href="<?php echo esc_url( add_query_arg( 'content_type', 'articles', rlx_signal_archive_url( 'rlx_story', '/hearing-content/' ) ) ); ?>">聽力小百科</a></li></ul></li>
					<li><a href="<?php echo esc_url( rlx_signal_archive_url( 'rlx_brand', '/hearing-aid-brands/' ) ); ?>">產品介紹</a></li>
					<li><a href="<?php echo esc_url( rlx_signal_archive_url( 'rlx_news', '/news/' ) ); ?>">最新消息</a></li>
					<li><a href="<?php echo esc_url( rlx_signal_page_url( 'stores', '/stores/' ) ); ?>">門市據點</a></li>
					<li><a href="<?php echo esc_url( rlx_signal_page_url( 'government-subsidy', '/government-subsidy/' ) ); ?>">政府補助</a></li>
					<li><a href="https://www.kingpax.com.tw/xmdoc/cont?xsmsid=0J118466602525889281&amp;sid=0P254441717060950753">加入我們</a></li>
				</ul>
				<?php
			}
			?>
		</nav>

		<a class="header-reservation" href="<?php echo esc_url( rlx_signal_home_mod( 'rlx_about_button_url', rlx_signal_page_url( 'appointment', '/appointment/' ) ) ); ?>"><span aria-hidden="true">◔</span> 線上預約</a>
		<div class="header-contact">
			<span aria-hidden="true">♙</span>
			<p>
				<a href="<?php echo esc_url( rlx_signal_phone_href() ); ?>"><?php echo esc_html( rlx_signal_get_phone() ); ?></a>
				<a href="mailto:<?php echo esc_attr( rlx_signal_get_email() ); ?>"><?php echo esc_html( rlx_signal_get_email() ); ?></a>
			</p>
		</div>
	</div>
</header>
