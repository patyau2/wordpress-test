<?php
/**
 * Database-backed Smart Hearing inspired homepage.
 *
 * @package RLX_Signal
 */

get_header();

$hero_slides = rlx_signal_section_posts( 'rlx_hero_slide', 9 );
$news_items  = rlx_signal_section_posts( 'rlx_news', 3 );
$stories     = rlx_signal_story_posts( 'stories', 2 );
$articles    = rlx_signal_story_posts( 'articles', 2 );
$brands      = rlx_signal_section_posts( 'rlx_brand', 4 );
$promos      = rlx_signal_section_posts( 'rlx_promo', 3 );
?>

<main id="main">
	<section class="home-hero" aria-label="睿聲助聽器最新活動" data-hero-slider>
		<?php foreach ( $hero_slides as $index => $slide ) : ?>
			<?php
			$slide_id     = $slide->ID;
			$desktop_url  = rlx_signal_post_image_url( $slide_id, 'rlx_image', 'hero-active.webp' );
			$mobile_url   = rlx_signal_image_url( rlx_signal_post_meta( $slide_id, 'rlx_mobile_image', 'hero-active-mobile.jpg' ) );
			$slide_active = 0 === $index;
			?>
			<a
				href="<?php echo rlx_signal_post_link( $slide_id, '#products' ); ?>"
				class="hero-slide <?php echo $slide_active ? 'is-active' : ''; ?>"
				data-hero-slide
				<?php echo $slide_active ? '' : 'aria-hidden="true" tabindex="-1"'; ?>
			>
				<picture>
					<?php if ( $mobile_url ) : ?>
						<source media="(max-width: 767px)" srcset="<?php echo esc_url( $mobile_url ); ?>">
					<?php endif; ?>
					<img src="<?php echo esc_url( $desktop_url ); ?>" alt="<?php echo esc_attr( get_the_title( $slide_id ) ); ?>" width="1920" height="850" fetchpriority="<?php echo $slide_active ? 'high' : 'auto'; ?>">
				</picture>
			</a>
		<?php endforeach; ?>

		<?php if ( count( $hero_slides ) > 1 ) : ?>
			<button class="slider-arrow slider-arrow-left" type="button" aria-label="上一張" data-hero-prev><span aria-hidden="true">‹</span></button>
			<button class="slider-arrow slider-arrow-right" type="button" aria-label="下一張" data-hero-next><span aria-hidden="true">›</span></button>
			<div class="slider-dots" aria-label="活動輪播">
				<?php foreach ( $hero_slides as $index => $slide ) : ?>
					<button type="button" class="<?php echo 0 === $index ? 'is-active' : ''; ?>" aria-label="第 <?php echo esc_attr( $index + 1 ); ?> 張" data-hero-dot="<?php echo esc_attr( $index ); ?>"></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>

	<section id="news" class="news-section">
		<div class="home-container news-layout">
			<header class="home-title news-title">
				<p><?php echo esc_html( rlx_signal_home_mod( 'rlx_news_eyebrow', 'News' ) ); ?></p>
				<h2><?php echo esc_html( rlx_signal_home_mod( 'rlx_news_heading', '睿聲快訊' ) ); ?></h2>
				<img src="<?php echo rlx_signal_asset( 'smarthearing/news-hearing-aids.png' ); ?>" alt="" width="315" height="300">
			</header>
			<div class="news-cards">
				<?php foreach ( $news_items as $item ) : ?>
					<?php
					$item_id  = $item->ID;
					$image    = rlx_signal_post_image_url( $item_id, 'rlx_image' );
					$date     = rlx_signal_post_meta( $item_id, 'rlx_display_date', get_the_date( 'Y.m.d', $item_id ) );
					$category = rlx_signal_first_term_name( $item_id, 'rlx_news_category' );
					?>
					<article class="news-card">
						<a href="<?php echo rlx_signal_post_link( $item_id ); ?>">
							<?php if ( $image ) : ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $item_id ) ); ?>" width="520" height="345" loading="lazy">
							<?php endif; ?>
							<p class="news-meta"><?php echo esc_html( trim( $date . ( $category ? ' | ' . $category : '' ) ) ); ?></p>
							<h3><?php echo esc_html( get_the_title( $item_id ) ); ?></h3>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="about" class="reservation-section">
		<div class="home-container reservation-inner">
			<div class="reservation-copy">
				<p class="english-title"><?php echo esc_html( rlx_signal_home_mod( 'rlx_about_eyebrow', 'Hearing is Our Concern' ) ); ?></p>
				<h2><?php echo esc_html( rlx_signal_home_mod( 'rlx_about_heading', '助聽器產品和解決顧客聽力問題的領導者' ) ); ?></h2>
				<p><?php echo esc_html( rlx_signal_home_mod( 'rlx_about_body', '提供在地化服務，並透過精密的檢測設備、專業聽力師及選配人員，導入歐美多品牌高品質助聽器產品，讓您買的放心，聽的安心。' ) ); ?></p>
			</div>
			<a class="reservation-button" href="<?php echo esc_url( rlx_signal_home_mod( 'rlx_about_button_url', rlx_signal_page_url( 'appointment', '/appointment/' ) ) ); ?>">
				<span aria-hidden="true" class="ear-mark">◖</span>
				<span><strong><?php echo esc_html( rlx_signal_home_mod( 'rlx_about_button_title', '立即預約 聆聽美好' ) ); ?></strong><small><?php echo esc_html( rlx_signal_home_mod( 'rlx_about_button_subtitle', 'Reservation' ) ); ?></small></span>
				<i aria-hidden="true">›</i>
			</a>
		</div>
	</section>

	<section id="knowledge" class="stories-section">
		<div class="story-tabs" role="tablist" aria-label="聽力內容">
			<button id="stories-tab" class="story-tab is-active" type="button" role="tab" aria-selected="true" aria-controls="stories-panel" data-story-tab="stories">
				<span aria-hidden="true">◔</span> 聽友分享
			</button>
			<button id="articles-tab" class="story-tab" type="button" role="tab" aria-selected="false" aria-controls="articles-panel" data-story-tab="articles">
				<span aria-hidden="true">▤</span> 聽力小百科
			</button>
		</div>
		<div class="home-container">
			<div id="stories-panel" class="story-panel is-active" role="tabpanel" aria-labelledby="stories-tab" data-story-panel="stories">
				<?php foreach ( $stories as $story ) : ?>
					<?php
					$story_id = $story->ID;
					$image    = rlx_signal_post_image_url( $story_id, 'rlx_image' );
					$label    = rlx_signal_first_term_name( $story_id, 'rlx_story_type' );
					?>
					<article class="story-card">
						<?php if ( $image ) : ?>
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $story_id ) ); ?>" width="650" height="415" loading="lazy">
						<?php endif; ?>
						<div>
							<p class="story-kind"><?php echo esc_html( $label ); ?></p>
							<h3><?php echo esc_html( get_the_title( $story_id ) ); ?></h3>
							<p><?php echo esc_html( rlx_signal_excerpt( $story_id ) ); ?></p>
							<a href="<?php echo rlx_signal_post_link( $story_id ); ?>"><?php echo esc_html( rlx_signal_post_meta( $story_id, 'rlx_link_label', '更多內容' ) ); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<div id="articles-panel" class="story-panel" role="tabpanel" aria-labelledby="articles-tab" data-story-panel="articles" hidden>
				<?php foreach ( $articles as $article ) : ?>
					<?php
					$article_id = $article->ID;
					$image      = rlx_signal_post_image_url( $article_id, 'rlx_image' );
					$label      = rlx_signal_first_term_name( $article_id, 'rlx_story_type' );
					?>
					<article class="story-card">
						<?php if ( $image ) : ?>
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $article_id ) ); ?>" width="650" height="415" loading="lazy">
						<?php endif; ?>
						<div>
							<p class="story-kind"><?php echo esc_html( $label ); ?></p>
							<h3><?php echo esc_html( get_the_title( $article_id ) ); ?></h3>
							<p><?php echo esc_html( rlx_signal_excerpt( $article_id ) ); ?></p>
							<a href="<?php echo rlx_signal_post_link( $article_id ); ?>"><?php echo esc_html( rlx_signal_post_meta( $article_id, 'rlx_link_label', '更多內容' ) ); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="story-progress" aria-hidden="true"><span></span></div>
		</div>
	</section>

	<section id="products" class="brands-section">
		<header class="home-title centered-title">
			<p><?php echo esc_html( rlx_signal_home_mod( 'rlx_brands_eyebrow', 'Collection' ) ); ?></p>
			<h2><?php echo esc_html( rlx_signal_home_mod( 'rlx_brands_heading', '嚴選優質品牌' ) ); ?></h2>
		</header>
		<div class="home-container brand-row">
			<?php foreach ( $brands as $brand ) : ?>
				<?php
				$brand_id = $brand->ID;
				$image    = rlx_signal_post_image_url( $brand_id, 'rlx_image' );
				?>
				<article class="brand-card">
					<?php if ( $image ) : ?>
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $brand_id ) ); ?>" loading="lazy">
					<?php endif; ?>
					<h3><?php echo esc_html( get_the_title( $brand_id ) ); ?></h3>
					<a href="<?php echo rlx_signal_post_link( $brand_id ); ?>"><?php echo esc_html( rlx_signal_post_meta( $brand_id, 'rlx_link_label', '系列商品' ) ); ?></a>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="brand-dots" aria-hidden="true">
			<?php foreach ( $brands as $brand ) : ?>
				<i></i>
			<?php endforeach; ?>
		</div>
	</section>

	<section id="stores" class="promo-section">
		<div class="home-container promo-grid">
			<?php foreach ( $promos as $promo ) : ?>
				<?php
				$promo_id = $promo->ID;
				$image    = rlx_signal_post_image_url( $promo_id, 'rlx_image' );
				?>
				<a href="<?php echo rlx_signal_post_link( $promo_id ); ?>">
					<?php if ( $image ) : ?>
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $promo_id ) ); ?>" width="600" height="400" loading="lazy">
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
