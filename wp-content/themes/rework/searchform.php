<form class="form-inline" action="<?php echo esc_url(home_url("/")); ?>" id="searchform" method="get" role="search">
	<input name="s" id="s" type="text" class="search"  value="<?php echo (get_search_query()) ? get_search_query() : __pe("Search")  ?>" default-value="<?php echo esc_attr(__pe("Search")); ?>"/>
</form>