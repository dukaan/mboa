					<?php 
						global $redux_demo;
						$betubeFooterON = $redux_demo['betube-footer-on'];
						$betubeBacktoTop = $redux_demo['backtotop'];
						$betubeBoxedWide = $redux_demo['betube_boxed'];
						$betubeBoxedAdv1 = $redux_demo['betube-google-adv-boxed-v1'];
						$betubeBoxedAdv2 = $redux_demo['betube-google-adv-boxed-v2'];
						$betubeFooterWidth = $redux_demo['betube_footer_fullwidth'];						
					?>
					<?php if($betubeBoxedWide == 'boxed'){ ?>
						<?php if(!empty($betubeBoxedAdv1)){?>
						<div class="side__adv side__adv_left">
							<?php echo $betubeBoxedAdv1; ?>
						</div>
						<?php } ?>
						<?php if(!empty($betubeBoxedAdv2)){?>
						<div class="side__adv side__adv_right">
							<?php echo $betubeBoxedAdv2; ?>
						</div>
						<?php } ?>
					<?php }?>
					<?php if($betubeFooterON == 1){ ?>
					<footer class="footer">
						<div class="row small-up-1 medium-up-2 large-up-4 <?php if($betubeFooterWidth == 'fullwidth'){echo 'expanded';}?>" data-equalizer data-equalize-by-row="true">							
							<?php dynamic_sidebar( 'footer' ); ?>
						</div><!--End Footer Row-->
					</footer> <!-- end .footer -->
					<?php }?>
					<?php if($betubeBacktoTop == 1){?>
						<a href="#" id="back-to-top" title="<?php esc_html_e('Back to top', 'betube'); ?>"><i class="fa fa-angle-double-up"></i></a>
					<?php } ?>
					<div id="footer-bottom">
					<?php 
						global $redux_demo;
						$betubeFLogo = $redux_demo['footer-logo']['url'];
						$betubeCopyRights = $redux_demo['footer_copyright'];
						$betubeBlogTitle = get_bloginfo('name');
						if(!empty($betubeFLogo)){
					?>
						<div class="logo text-center">
							<img src="<?php echo esc_url($betubeFLogo); ?>" alt="<?php echo $betubeBlogTitle; ?>">
						</div><!--Footer LOGO -->
						<?php } 
						if(!empty($betubeCopyRights)){
						?>
						<div class="btm-footer-text text-center">
							<p><?php echo $betubeCopyRights; ?></p>
						</div><!--CopyRightText -->
						<?php }?>
					</div><!--footer-bottom -->
				</div>  <!-- end .main-content -->
			</div> <!-- end .off-canvas-wrapper-inner -->
		</div> <!-- end .off-canvas-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html> <!-- end page -->