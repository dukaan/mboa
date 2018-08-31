<?php
/**
 * The template for displaying archives of blog categories
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 2.0
 */
 ?>
<?php get_header();?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$wp_query->get_queried_object();	
	betube_breadcrumbs()
?>
<?php //if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="category-content">
	<div class="row">
		<!-- left side content area -->
		<div class="large-8 columns">			
			<?php if (have_posts() ): ?>
			<?php while (have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'blog-loop' ); ?>
			<?php endwhile; ?>
			<!--Paginatation-->
			<div class="row">
				<div class="large-12 columns"><?php get_template_part('pagination'); ?></div>
			</div>
			<!--Paginatation-->
			<?php 
				else :
				echo "Sorry, Nothing found";
				endif;
				wp_reset_postdata();
			?>
		</div><!--End Large8-->
		<!-- left side content area -->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
					<?php dynamic_sidebar('blog'); ?>
				</div>
			</aside>
		</div>
	</div>
</section>
<?php //endwhile; endif; ?>
<?php get_footer(); ?>