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
			<img src="<?php echo rlx_signal_asset( 'smarthearing/logo.svg' ); ?>" alt="睿聲助聽器 Smart Hearing Group" width="230" height="64">
		</a>

		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
			<span><?php esc_html_e( '選單', 'rlx-signal' ); ?></span>
			<i aria-hidden="true"></i>
		</button>

		<nav id="primary-menu" class="primary-nav" aria-label="主要導覽">
			<ul class="nav-list">
				<li><a href="#about">關於我們</a></li>
				<li><a href="#knowledge">聽力小百科</a></li>
				<li><a href="#products">產品介紹</a></li>
				<li><a href="#news">最新消息</a></li>
				<li><a href="#stores">門市據點</a></li>
				<li><a href="#contact">政府補助</a></li>
				<li><a href="#contact">加入我們</a></li>
			</ul>
		</nav>

		<a class="header-reservation" href="#contact"><span aria-hidden="true">◔</span> 線上預約</a>
		<div class="header-contact">
			<span aria-hidden="true">♙</span>
			<p><a href="tel:0800580590">0800-580-590</a><a href="mailto:info@smarthearing.com.tw">info@smarthearing.com.tw</a></p>
		</div>
	</div>
</header>
