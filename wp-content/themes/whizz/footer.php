<?php
/**
 *
 * Footer
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if( is_page() || is_home()) {
	$post_id = get_queried_object_id();
} else {
	$post_id = get_the_ID();
}
// page options
$meta_data = get_post_meta( $post_id, '_custom_page_options', true );
$meta_data_portfolio = get_post_meta( $post_id, 'whizz_portfolio_options', true );
$meta_data_events = get_post_meta( get_the_ID(), 'whizz_events_options', true );
$class_footer = !empty($meta_data['fixed_transparent_footer']) || is_404() || (!empty($meta_data_portfolio['fixed_transparent_footer']) || !empty($meta_data_events['fixed_transparent_footer']))? ' fix-bottom' : '';


$enable_footer_copy = isset($meta_data['enable_footer_copy_page']) ? $meta_data['enable_footer_copy_page'] : cs_get_option( 'enable_footer_copy' );
$enable_footer_widgets = isset($meta_data['enable_footer_widgets_page']) ? $meta_data['enable_footer_widgets_page'] : cs_get_option( 'enable_footer_widgets' );
$enable_footer_white = isset($meta_data['enable_footer_white_page']) ? $meta_data['enable_footer_white_page'] : cs_get_option( 'enable_footer_white' );
$enable_footer_parallax = isset($meta_data['enable_parallax_footer_page']) ? $meta_data['enable_parallax_footer_page'] : cs_get_option( 'enable_parallax_footer' );
$copyright_align = isset($meta_data['whizz_copyright_align']) ? $meta_data['whizz_copyright_align'] : cs_get_option( 'whizz_copyright_align' );
$change_footer = cs_get_option( 'whizz_copyright_align' );

if(empty($copyright_align)){
	$copyright_align = 'center';
}

if(isset($meta_data_portfolio['enable_footer_copy_page'])){
    $enable_footer_copy = $meta_data_portfolio['enable_footer_copy_page'];
}elseif(isset($meta_data_events['enable_footer_copy_page'])){
    $enable_footer_copy = $meta_data_events['enable_footer_copy_page'];
}

if(isset($meta_data_portfolio['enable_footer_widgets_page'])){
	$enable_footer_widgets = $meta_data_portfolio['enable_footer_widgets_page'];
}elseif(isset($meta_data_events['enable_footer_widgets_page'])){
	$enable_footer_widgets = $meta_data_events['enable_footer_widgets_page'];
}

if(!$enable_footer_copy && !$enable_footer_widgets){
	$class_footer .= ' no-footer';
}

if($enable_footer_white){
	$class_footer .= ' white-footer';
}

$enable_footer_parallax = apply_filters( 'whizz_blog_footer_style', $enable_footer_parallax );
if($enable_footer_parallax){
	$class_footer .= ' footer-parallax';
}

if(is_404() && cs_get_option('change_footer') == true){
	$enable_footer_copy = cs_get_option('enable_footer_copy_404');
	$enable_footer_widgets = cs_get_option('enable_footer_widgets_404');
} ?>

</div>
<footer id="footer" class="<?php echo esc_attr( $class_footer ); ?>">
	<div class="container-fluid">
		<?php if(!empty($enable_footer_copy) && $enable_footer_copy == true){ ?>
			<div class="copyright text-<?php echo esc_attr($copyright_align); ?>">
				<?php
				$footer_text = cs_get_option( 'footer_text' ) ? cs_get_option( 'footer_text' ) : ' ';
				echo wp_kses_post( $footer_text );
				?>
			</div>
		<?php }
		if ( ! function_exists( 'cs_framework_init' ) ) { ?>

            <div class="copyright text-center">
                <?php
                	$footer_text = esc_html__( ' &copy;', 'whizz' ) . date( 'Y' );
                	echo wp_kses_post( $footer_text . bloginfo( 'name' ));
                ?>
            </div>

			<?php
		}
		?>
	</div>
	<div class="container no-padd">
	<?php if(!function_exists( 'cs_framework_init' ) || (!empty($enable_footer_widgets) && $enable_footer_widgets == true)){ ?>
		<div class="widg clearfix">
			<?php if ( is_active_sidebar( 'footer_sidebar' ) ) {
                dynamic_sidebar( 'footer_sidebar' );
			}
			?>
		</div>
	<?php } ?>
	</div>

</footer>

<?php
$classCopy = cs_get_option('enable_copyright') && !cs_get_option('text_copyright') ? '' : 'copy';
if ( cs_get_option('enable_copyright') ): ?>
<div class="whizz_copyright_overlay <?php echo esc_attr($classCopy); ?>">
	<div class="whizz_copyright_overlay.active">
		<?php if( cs_get_option('text_copyright') ) : ?>
		<div class="whizz_copyright_overlay_text">
			<?php echo wp_kses_post(cs_get_option('text_copyright')); ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<div class="fullview">
	<div class="fullview__close"></div>
</div>

<?php if(cs_get_option('page_scroll_top') == true){ ?>
	<div class="scroll-top-button">
		<a href="#" id="back-to-top">&uarr;</a>
	</div>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>