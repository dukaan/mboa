<?php
/**
 * Template Name: Blog Main Page
 *
 * The template for displaying the Main Blog Page.
 *
 * it will loop and display the blog posts
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */

get_header();
betube_breadcrumbs()
 ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="category-content">
	<div class="row">
		<!-- left side content area -->
		<div class="large-8 columns">
			<?php
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
				$blog_args = array (
					'post_type' => 'blog',
					'paged' => $paged,
					);
				$blog_query = new WP_Query( $blog_args );	
			?>
			<?php if ( $blog_query->have_posts() ): ?>
			<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
			<?php get_template_part( 'content', 'blog-loop' ); ?>
			<?php endwhile; ?>
			<!--Paginatation-->
			<div class="row">
				<div class="large-12 columns">
					<?php 
					//pagination
					$big = 999999999; // need an unlikely integer		
					echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $blog_query->max_num_pages
						) );                        
					?>
				</div>
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
					<?php get_sidebar('blog'); ?>
				</div>
			</aside>
		</div>
	</div>
</section>
<?php endwhile; endif; ?>
<?php get_footer(); ?>