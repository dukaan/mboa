<div class="large-12 medium-12 columns">
	<div id="post-not-found" class="hentry">
		
		<?php if ( is_search() ) : ?>
			
			<header class="article-header">
				<h1><?php esc_html_e( 'Sorry, No Results.', 'betube' );?></h1>
			</header>
			
			<section class="entry-content">
				<p><?php esc_html_e( 'Try your search again.', 'betube' );?></p>
			</section>
			
			<section class="search">
				<p><?php get_search_form(); ?></p>
			</section> <!-- end search section -->		
			
			
		<?php else: ?>
		
			<header class="article-header">
				<h1><?php esc_html_e( 'Oops, Post Not Found!', 'betube' ); ?></h1>
			</header>
			
			<section class="entry-content">
				<p><?php esc_html_e( 'Uh Oh. Something is missing. Try double checking things.', 'betube' ); ?></p>
			</section>
			
			<section class="search">
				<p><?php get_search_form(); ?></p>
			</section> <!-- end search section -->	
			
				
		<?php endif; ?>
		
	</div>
</div>