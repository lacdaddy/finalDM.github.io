<?php
/**
 * 404 Page
 *
 * @package whizz
 * @since 1.0
 *
 */

$btntext = cs_get_option( 'error_btn_text' ) ? cs_get_option( 'error_btn_text' ) : esc_html__('Go home', 'whizz');

get_header();
?>
	<div class="container-fluid no-padd error-height">
		<div class="hero-inner bg-cover full-height-hard">

			<?php if ( cs_get_option( 'image_404' ) ): ?>
				<?php
				echo whizz_the_lazy_load_flter( cs_get_option( 'image_404' ), array(
				  'class' => 's-img-switch',
				  'alt'   => esc_attr__( '404 image', 'whizz' )
				) );
				?>
			<?php
            endif; ?>
			<div class="overlay overlay-dark-error"></div>
			<div class="fullheight text-light text-center">
				<div class="vertical-align">
					<h1 class="bigtext margin-lg-10t"><?php esc_html_e( '404 error', 'whizz' ); ?></h1>
					<h6 class="title bold font-1 text-uppercase"><?php echo esc_html( cs_get_option( 'error_title' ) ); ?></h6>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="margin-lg-15t a-btn"><?php echo esc_html( $btntext ); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php get_footer();
