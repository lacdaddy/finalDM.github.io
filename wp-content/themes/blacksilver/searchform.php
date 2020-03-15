<?php
$search_buttontext = blacksilver_get_option_data( 'search_buttontext' );
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<input type="text" value="" name="s" id="s" class="right" />
<button class="ntips" id="searchbutton" title="<?php echo esc_html( $search_buttontext ); ?>" type="submit"><i class="fa fa-search"></i></button>
</form>
