<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
    <div>
    	<label class="screen-reader-text" for="s">Search for: </label>
	    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search..." />
	    <input type="submit" id="searchsubmit" value="search" />
    </div>
</form>	