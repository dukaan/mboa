<?php get_header(); ?>
<section class="category-content">
	<div class="row">
		<div class="large-8 columns">
			<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'blog-loop' ); ?>
			<?php endwhile; ?>
			<?php get_template_part('pagination');?>
			<?php else : ?>			
			<?php get_template_part( 'parts/content', 'missing' ); ?>
			<?php endif; ?>
		</div><!--row-->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
					<?php get_sidebar(); ?>
				</div>
			</aside>
		</div>
	</div><!--row-->
</section><!--category-content-->			
<?php get_footer(); ?>