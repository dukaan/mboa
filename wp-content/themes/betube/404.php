<?php get_header(); ?>
<?php betube_breadcrumbs();?>
<section class="error-page">
	<div class="row secBg">
		<div class="large-8 large-centered columns">
			<div class="error-page-content text-center">
				<div class="error-img text-center">
					<img src="<?php echo get_template_directory_uri() . '/images/404-error.png' ?>" alt="404">
					<div class="spark">
						<img class="flash" src="<?php echo get_template_directory_uri() . '/images/spark.png' ?>" alt="spark">						
					</div><!--End spark-->
					<h1><?php esc_html_e( 'Page Not Found', 'betube' ); ?></h1>
					<p><?php esc_html_e( 'The page you were looking for was not found, but maybe try looking again!', 'betube' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php esc_html_e( 'Go Back Home Page', 'betube' ); ?></a>
					<p class="404search"><?php get_search_form(); ?></p>
				</div><!--End error-img-->
			</div><!--End error-page-content-->
		</div><!--End Large8-->
	</div><!--End row secbg-->
</section>
<?php get_footer(); ?>