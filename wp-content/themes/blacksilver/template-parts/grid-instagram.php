<?php
$columns          = 8;
$rows             = 2;
$token            = get_theme_mod( 'instagram_api' );
$insta_transition = get_theme_mod( 'insta_transition' );
if ( 'instagram-verticalmenu' === blacksilver_get_option_data( 'instagram_location' ) && 'vertical-menu' === blacksilver_get_option_data( 'menu_type' ) ) {
	$columns = 4;
	$rows    = 4;
}
if ( isset( $token ) ) {
	if ( '' !== $token && ! empty( $token ) ) {
		?>
		<div class="footer-end-block clearfix">
			<?php
			$insta_username = blacksilver_get_option_data( 'insta_username' );
			if ( '' !== $insta_username ) {
				?>
				<h3 class="instagram-username"><i class="fa fa-instagram"></i> <?php echo esc_html( $insta_username ); ?></h3>
				<?php
			}
			if ( shortcode_exists( 'insta_carousel' ) ) {
				$insta_image_limit = get_theme_mod( 'insta_image_limit' );
				if ( ! isset( $insta_image_limit ) || '0' === $insta_image_limit || '' === $insta_image_limit || empty( $insta_image_limit ) ) {
					$insta_image_limit = 20;
				}
				echo '<div id="insta-grid-id-detect" class="insta-grid-detect">';
				echo do_shortcode( '[insta_carousel insta_transition="' . $insta_transition . '" count="' . $insta_image_limit . '" rows="' . $rows . '" columns="' . $columns . '" token="' . $token . '"]' );
				echo '</div>';
			}
			?>
		</div>
		<?php
	}
}
