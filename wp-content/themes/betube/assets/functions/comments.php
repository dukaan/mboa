<?php
// Comment Layout
$args = array(
	'walker'            => null,
	'max_depth'         => '',
	'style'             => 'ul',
	'callback'          => null,
	'end-callback'      => null,
	'type'              => 'all',
	'reply_text'        => 'Reply',
	'page'              => '',
	'per_page'          => '',
	'avatar_size'       => 32,
	'reverse_top_level' => null,
	'reverse_children'  => '',
	'format'            => 'html5', // or 'xhtml' if no 'HTML5' theme support
	'short_ping'        => false,   // @since 3.6
        'echo'              => true     // boolean, default is true
);
function betube_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('panel'); ?>>
		<div class="media-object">
			<div class="media-object-section">
				<?php 
				//print_r($comment);
				$betubeCommentAuthorID = $comment->user_id;
				$betubeCommentALT = $comment->comment_author;
				$betubeCommentAuthorAvatar = get_user_meta($betubeCommentAuthorID, "betube_author_avatar_url", true);
				$betubeCommentAuthorAvatar = betube_get_image_url($betubeCommentAuthorAvatar);
				if(empty($betubeCommentAuthorAvatar)){
					echo get_avatar( $comment, 75 );
				}else{
					?>
					<img style="height:75px; width:75px;" src="<?php echo esc_url($betubeCommentAuthorAvatar); ?>" alt="<?php echo $betubeCommentALT;?>">
					<?php
				}	
				?>			    
			  </div>
			<div class="media-object-section">
				<article id="comment-<?php comment_ID(); ?>" class="clearfix large-12 columns">
					<header class="comment-author">
						<?php
							// create variable
							$bgauthemail = get_comment_author_email();
						?>
						<?php printf(__('%s', 'betube'), get_comment_author_link()) ?> <?php esc_html_e('on', 'betube') ?>
						<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__(' F jS, Y - g:ia', 'betube')); ?> </a></time>
						<?php edit_comment_link(__('(Edit)', 'betube'),'  ','') ?>
					</header>
					<?php if ($comment->comment_approved == '0') : ?>
						<div class="alert alert-info">
							<p><?php esc_html_e('Your comment is awaiting moderation.', 'betube') ?></p>
						</div>
					<?php endif; ?>
					<section class="comment_content clearfix">
						<?php comment_text() ?>
					</section>
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</article>
			</div>
		</div>
	<!-- </li> is added by WordPress automatically -->
<?php
}