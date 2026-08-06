<?php
/**
 * Smart Hearing inspired homepage.
 *
 * @package RLX_Signal
 */
get_header();

$asset = static function ( $filename ) {
	return rlx_signal_asset( 'smarthearing/' . $filename );
};

$news = array(
	array(
		'image'    => 'news-hear-more.webp',
		'date'     => '2026.06.30',
		'category' => '學術研討會',
		'title'    => 'Hear More 2026 - 接軌國際，聽見自信',
	),
	array(
		'image'    => 'news-holiday.webp',
		'date'     => '2026.06.17',
		'category' => '新聞快訊',
		'title'    => '端午連假｜睿聲門市公告',
	),
	array(
		'image'    => 'news-subsidy.jpg',
		'date'     => '2026.05.29',
		'category' => '新聞快訊',
		'title'    => '補助資訊｜睿聲助聽器',
	),
);

$brands = array(
	array( 'image' => 'brand-resound.png', 'title' => 'ReSound 助聽器' ),
	array( 'image' => 'brand-interton.png', 'title' => 'Interton 助聽器' ),
	array( 'image' => 'brand-audibel.png', 'title' => '美國 AUDIBEL 助聽器' ),
	array( 'image' => 'brand-phonak.jpg', 'title' => '瑞士 PHONAK 助聽器' ),
);
?>

<main id="main">
	<section class="home-hero" aria-label="睿聲助聽器最新活動">
		<a href="#products" class="hero-slide">
			<picture>
				<source media="(max-width: 767px)" srcset="<?php echo $asset( 'hero-active-mobile.jpg' ); ?>">
				<img src="<?php echo $asset( 'hero-active.webp' ); ?>" alt="睿聲助聽器最新活動" width="1920" height="850" fetchpriority="high">
			</picture>
		</a>
		<button class="slider-arrow slider-arrow-left" type="button" aria-label="上一張"><span aria-hidden="true">‹</span></button>
		<button class="slider-arrow slider-arrow-right" type="button" aria-label="下一張"><span aria-hidden="true">›</span></button>
		<div class="slider-dots" aria-label="活動輪播">
			<?php for ( $i = 1; $i <= 9; $i++ ) : ?>
				<button type="button" class="<?php echo 1 === $i ? 'is-active' : ''; ?>" aria-label="第 <?php echo esc_attr( $i ); ?> 張"></button>
			<?php endfor; ?>
		</div>
	</section>

	<section id="news" class="news-section">
		<div class="home-container news-layout">
			<header class="home-title news-title">
				<p>News</p>
				<h2>睿聲快訊</h2>
				<img src="<?php echo $asset( 'news-hearing-aids.png' ); ?>" alt="" width="315" height="300">
			</header>
			<div class="news-cards">
				<?php foreach ( $news as $item ) : ?>
					<article class="news-card">
						<a href="#">
							<img src="<?php echo $asset( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" width="520" height="345" loading="lazy">
							<p class="news-meta"><?php echo esc_html( $item['date'] . ' | ' . $item['category'] ); ?></p>
							<h3><?php echo esc_html( $item['title'] ); ?></h3>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="about" class="reservation-section">
		<div class="home-container reservation-inner">
			<div class="reservation-copy">
				<p class="english-title">Hearing is Our Concern</p>
				<h2>助聽器產品和解決顧客聽力問題的領導者</h2>
				<p>提供在地化服務，並透過精密的檢測設備、專業聽力師及選配人員，導入歐美多品牌高品質助聽器產品，讓您買的放心，聽的安心。</p>
			</div>
			<a class="reservation-button" href="#contact">
				<span aria-hidden="true" class="ear-mark">◖</span>
				<span><strong>立即預約 聆聽美好</strong><small>Reservation</small></span>
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
				<article class="story-card">
					<img src="<?php echo $asset( 'story-1.png' ); ?>" alt="睿聲聽友分享" width="650" height="415" loading="lazy">
					<div>
						<p class="story-kind">聽友分享</p>
						<h3>退休主任的無聲危機，積極面對突發耳聾 - 新營門市 吳委員</h3>
						<p>六月初，鄰近下班的傍晚。門市大門被匆忙推開，家人神情慌張，專業團隊立即提供聽力評估與協助。</p>
						<a href="#">更多內容</a>
					</div>
				</article>
				<article class="story-card">
					<img src="<?php echo $asset( 'story-2.jpg' ); ?>" alt="聽友重新掌握自信" width="650" height="415" loading="lazy">
					<div>
						<p class="story-kind">聽友分享</p>
						<h3>疫情導致聽損，陽光女孩重新掌握自信！ - 中山門市 黃經理</h3>
						<p>面對突如其來的高頻聽力損失，透過專業選配與調整，重新找回清楚溝通的自在生活。</p>
						<a href="#">更多內容</a>
					</div>
				</article>
			</div>
			<div id="articles-panel" class="story-panel" role="tabpanel" aria-labelledby="articles-tab" data-story-panel="articles" hidden>
				<article class="story-card">
					<img src="<?php echo $asset( 'story-3.png' ); ?>" alt="助聽器知識介紹" width="650" height="415" loading="lazy">
					<div>
						<p class="story-kind">聽力小百科</p>
						<h3>助聽器正確使用與保養全攻略</h3>
						<p>認識助聽器的功能、清潔保養技巧，以及配戴初期常見問題，讓聽力不卡卡。</p>
						<a href="#">更多內容</a>
					</div>
				</article>
				<article class="story-card">
					<img src="<?php echo $asset( 'story-4.png' ); ?>" alt="專業聽力檢查" width="650" height="415" loading="lazy">
					<div>
						<p class="story-kind">聽力小百科</p>
						<h3>如何在家自我聽力篩檢？</h3>
						<p>及早察覺聽力變化，並由專業人員進一步評估，是維持生活品質的重要一步。</p>
						<a href="#">更多內容</a>
					</div>
				</article>
			</div>
			<div class="story-progress" aria-hidden="true"><span></span></div>
		</div>
	</section>

	<section id="products" class="brands-section">
		<header class="home-title centered-title">
			<p>Collection</p>
			<h2>嚴選優質品牌</h2>
		</header>
		<div class="home-container brand-row">
			<?php foreach ( $brands as $brand ) : ?>
				<article class="brand-card">
					<img src="<?php echo $asset( $brand['image'] ); ?>" alt="<?php echo esc_attr( $brand['title'] ); ?>" loading="lazy">
					<h3><?php echo esc_html( $brand['title'] ); ?></h3>
					<a href="#">系列商品</a>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="brand-dots" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i></div>
	</section>

	<section id="stores" class="promo-section">
		<div class="home-container promo-grid">
			<a href="#"><img src="<?php echo $asset( 'promo-map.png' ); ?>" alt="睿聲門市地圖" width="600" height="400" loading="lazy"></a>
			<a href="#"><img src="<?php echo $asset( 'promo-subscription.png' ); ?>" alt="睿聲助聽器訂閱制方案" width="600" height="400" loading="lazy"></a>
			<a href="#"><img src="<?php echo $asset( 'promo-test.png' ); ?>" alt="線上聽力測試" width="600" height="400" loading="lazy"></a>
		</div>
	</section>
</main>

<?php get_footer(); ?>
