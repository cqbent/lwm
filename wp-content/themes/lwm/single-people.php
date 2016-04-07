<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all  cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

								<header class="article-header entry-header">

									<h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

								</header> <?php // end article header ?>

								<section class="entry-content cf" itemprop="articleBody">
									<div class="image-title">
										<?php
										$img = get_field('personal_photo');
										if ($img) {
											$img_output = wp_get_attachment_image( $img['id'], 'medium' );
										}
										else {
											$img_output = get_the_post_thumbnail(get_the_ID(), 'medium');
										}
										print
											$img_output. '
											<div class="name">'.get_the_title().'</div>
											<div class="credentials">'.get_field('credentials').'</div>
											<div class="job-title">'.get_field('job_title').'</div>
											';
										?>
									</div>
									<div class="bio">
										<?php
										the_content();
										?>
									</div>

								</section>

							</article>

						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
									</footer>
							</article>

						<?php endif; ?>

					</main>

					<?php //get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
