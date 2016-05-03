<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all  cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

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
											$img_output;
										?>
									</div>
									<div class="bio">
										<h2 class="name"><?php the_title(); ?><?php get_field('credentials') ? print ', '.get_field('credentials') : ''; ?></h2>
										<div class="job-title"><?php print get_field('job_title'); ?></div>
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
