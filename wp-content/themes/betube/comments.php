<?php
global $redux_demo;
$beTubeFBCommentOn = $redux_demo['betube-facebook-comment'];
$beTubeFBAPPID = $redux_demo['betubefbappid'];
if($beTubeFBCommentOn == 1){
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo $beTubeFBAPPID; ?>&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-width="780" data-colorscheme="light"></div>
	<?php
}else{
	if ( post_password_required() ) {
		return;
	}
?>
<div class="large-12 columns">
	<?php // You can start editing here ?>

		<?php if ( have_comments() ) : ?>
			<div class="main-heading borderBottom">
				<div class="row padding-14">
					<div class="medium-12 small-12 columns">
						<div class="head-title">
							<i class="fa fa-comments"></i>
							<h4>
								<?php
								printf( // WPCS: XSS OK.
									esc_html( _nx( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'betube' ) ),
									number_format_i18n( get_comments_number() ),
									'<span>' . get_the_title() . '</span>'
								);
								?>
							</h4>
						</div><!--head-title-->
					</div><!--medium-12-->
				</div><!--row padding-14-->
			</div><!--main-heading-->
			
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'betube' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'betube' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'betube' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
			<?php endif; // Check for comment navigation. ?>

			<ol class="commentlist">
				<?php wp_list_comments('type=comment&callback=betube_comments'); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'betube' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'betube' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'betube' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
			<?php endif; // Check for comment navigation. ?>

		<?php endif; // Check for have_comments(). ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'betube' ); ?></p>
		<?php endif; ?>

		<?php comment_form(array('class_submit'=>'button')); ?>


</div><!--large-12 -->
<?php }?>