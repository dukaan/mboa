<?php 
	$page = get_page($post->ID);
	$beeTubeCurPageID = $page->ID;
	$beeTubePageslider = get_post_meta($beeTubeCurPageID, 'page_slider', true); 
	global $redux_demo;
?>
<?php if($beeTubePageslider == "LayerSlider") : ?>
<section id="slider">
	<div id="full-slider-wrapper">
		<div id="layerslider">
			<?php $betubeSlidershortcode = get_post_meta($beeTubeCurPageID, 'layerslider_shortcode', true);?>
			<?php 
				if(!empty($betubeSlidershortcode)){
					echo do_shortcode($betubeSlidershortcode);
				}else{
					echo do_shortcode('[layerslider id="1"]');
				}
			?>
		</div><!--End div layerslider-->
	</div><!--End full-slider-wrapper-->
</section><!--End Section Slider-->
<?php endif; ?>