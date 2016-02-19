<?php
/**
 * @package Make
 */

get_header();
global $post;
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$credentials = get_field('credentials') ? ', '.get_field('credentials') : '';
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">
			<div class="sidebars-column-1">
				<figure class="entry-thumbnail post-header">
					<?php the_post_thumbnail('medium'); ?>
				</figure>
			</div>
			<div class="sidebar-content">
				<header class="article-header">
					<h1 class="single-title custom-post-type-title"><?php the_title(); ?><?php print $credentials; ?></h1>
				</header>
				<section class="entry-content cf">
					<div class="job-title"> <?php the_field('job_title'); ?> </div>
					<div class="bio"><?php the_content(); ?></div>
				</section>
			</div>



		</article>
	<?php endwhile; ?>

<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
