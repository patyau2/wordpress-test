<?php
/**
 * Site footer.
 *
 * @package RLX_Signal
 */
?>
<footer id="contact" class="site-footer">
	<div class="home-container footer-main">
		<div class="footer-legal">
			<?php
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			if ( $custom_logo_id ) {
				echo wp_get_attachment_image( $custom_logo_id, 'full', false, array( 'alt' => get_bloginfo( 'name' ) ) );
			} else {
				?>
				<img src="<?php echo rlx_signal_asset( 'smarthearing/logo.svg' ); ?>" alt="睿聲助聽器" width="220" height="62">
				<?php
			}
			?>
			<p><?php echo nl2br( esc_html( rlx_signal_home_mod( 'rlx_footer_legal', "衛部醫器輸壹字第018320號\n衛部醫器輸壹字第020282號\n衛署醫器輸壹字第010085號" ) ) ); ?></p>
			<nav aria-label="頁尾導覽">
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'footer-nav-list',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<a href="<?php echo esc_url( rlx_signal_home_mod( 'rlx_about_button_url', rlx_signal_page_url( 'appointment', '/appointment/' ) ) ); ?>">線上預約</a>
					<a href="<?php echo esc_url( rlx_signal_page_url( 'sitemap', '/sitemap/' ) ); ?>">網站地圖</a>
					<a href="<?php echo esc_url( rlx_signal_page_url( 'privacy-policy', '/privacy-policy/' ) ); ?>">隱私權政策</a>
					<a href="https://crm.smarthearing.com.tw/">經銷商登入</a>
					<?php
				}
				?>
			</nav>
		</div>
		<div class="footer-contact">
			<a href="<?php echo esc_url( get_theme_mod( 'rlx_facebook_url', 'https://www.facebook.com/Smarthearingaids/' ) ); ?>" aria-label="Facebook"><b aria-hidden="true">f</b> Facebook</a>
			<a href="<?php echo esc_url( rlx_signal_phone_href() ); ?>"><b aria-hidden="true">☎</b> 免付費專線：<?php echo esc_html( rlx_signal_get_phone() ); ?></a>
			<a href="mailto:<?php echo esc_attr( rlx_signal_get_email() ); ?>"><b aria-hidden="true">✉</b> <?php echo esc_html( rlx_signal_get_email() ); ?></a>
		</div>
	</div>
	<div class="footer-base">
		<p><?php echo esc_html( rlx_signal_home_mod( 'rlx_footer_copyright', 'Copyright © 睿聲科技股份有限公司 Smart Hearing Group 版權所有　衛部醫器輸壹字第020499號，北市衛器廣字第108090250號' ) ); ?></p>
	</div>
</footer>

<a class="line-dock" href="<?php echo esc_url( get_theme_mod( 'rlx_line_url', 'https://lin.ee/DqE9QxN' ) ); ?>" aria-label="LINE 客服">
	<img src="<?php echo rlx_signal_asset( 'smarthearing/line-icon.png' ); ?>" alt="" width="32" height="32">
	<span>LINE</span>
</a>
<a class="top-dock" href="#main" aria-label="回到頁首">⌃</a>

<?php wp_footer(); ?>
</body>
</html>
