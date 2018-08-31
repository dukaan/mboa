<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" class="input-group-field" placeholder="<?php echo esc_attr_x( 'Enter Your Keyword', '', 'betube' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', '', 'betube' ) ?>" />
		<div class="input-group-button">
			<input type="submit" class="button" value="<?php echo esc_attr_x( 'Search',  '', 'betube' ) ?>" />
		</div>
	</div>
</form>