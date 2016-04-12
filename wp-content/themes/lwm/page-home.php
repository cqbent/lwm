<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class=" cf">

		<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">



			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
					<div class="entry-content cf" itemprop="articleBody">
						<section class="section-top case-studies columns-3 wrap">
							<h2 class="section-title">Case Studies</h2>
							<div class="col-1">
								<h3 class>Case Study 1</h3>
								<p>Lorem ipsum... <a href="#">read more</a></p>
							</div>
							<div class="col-2">
								<h3>Case Study 2</h3>
								<p>Lorem ipsum... <a href="#">read more</a></p>
							</div>
							<div class="col-3">
								<h3>Case Study 3</h3>
								<p>Lorem ipsum... <a href="#">read more</a></p>
							</div>

						</section>
						<!--
						<section class="section-1 builder-section">
							<div class="flex box-container">
								<div class="flex column col-2">
									<div class="flex box testimonial blue">
										<div>
											<p class="quote">“Sedi raceaquas nquo
												beatur am et ut aut que
												estiisquis etus ute”
											<p class="attribute">Client Name</p>

										</div>
									</div>
									<div class="flex box featured-event"><?php //print do_shortcode('[event_block]'); ?></div>
									<div class="flex box image" style="background-image:url(/wp-content/uploads/2015/08/not_whine.jpg);">
										&nbsp;</div>
									<div class="flex box green">
										<div class="arrow-left"></div>
										<div>
											<h4>As autatur lore, omnis repudicid que</h4>
											Axim aut optatur moluptation con periberum que et
											doluptat.Sequam, volup <a href="#">MORE</a></div>
									</div>
								</div>
								<div class="flex column col-1">
									<div class="flex box cell video-container">
										<iframe width="500" height="281" src="https://www.youtube.com/embed/HAhzVpJL7xQ" frameborder="0" allowfullscreen></iframe></div>
								</div>
							</div>
						</section>
						-->
						<section class="section-2 wrap">
							<div class="tagline">
								<p>
									<cite>Connecting The Head And Heart Of Wealth Management we listen, we ask questions, and we focus on delivering solutions to their personal and portfolio needs.</cite>
								</p>
							</div>
						</section>
						<section class="section-3 carousel">
							<?php print do_shortcode('[people_carousel]'); ?>
						</section>

						<section class="section-4 news-feature wrap">
							<?php print do_shortcode('[news_feature]'); ?>
						</section>

					</div>

				</article>

			<?php endwhile; endif; ?>

		</main>

		<?php //get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
