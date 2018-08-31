<article id="post-<?php the_ID(); ?>" role="article" itemscope itemtype="http://schema.org/WebPage" class="page-content">
<section class="entry-content" itemprop="articleBody">
	    <?php the_content(); ?>
	    <?php wp_link_pages(); ?>
</section> <!-- end article section -->  
	<?php comments_template(); ?>
</article> <!-- end article -->