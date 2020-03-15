<?php
/**
 *
 * The Header for Whizz theme
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if( is_page() || is_home()) {
    $post_id = get_queried_object_id();
} else {
    $post_id = get_the_ID();
}

$meta_data = get_post_meta( $post_id, '_custom_page_options', true );
$menu_main_style = cs_get_option( 'menu_style' );

if(isset($meta_data['change_menu']) && $meta_data['change_menu'] && isset($meta_data['menu_style'])){
    $menu_main_style = $meta_data['menu_style'];
}

$bodyClass = '';
if( $menu_main_style && $menu_main_style == 'right' ){
	$menu_class = 'right-menu';
}elseif($menu_main_style && $menu_main_style == 'compact'){
	$menu_class = 'right-menu compact';
}elseif($menu_main_style && $menu_main_style == 'left'){
	$menu_class = 'right-menu left';
}elseif($menu_main_style && $menu_main_style == 'aside'){
	$menu_class = 'right-menu aside-menu';
}elseif($menu_main_style && $menu_main_style == 'static_aside'){
	$menu_class = 'right-menu aside-menu static';
	$bodyClass = 'static-menu';
}elseif($menu_main_style && $menu_main_style == 'full'){
	$menu_class = 'right-menu compact full';
}else{
	$menu_class = 'top-menu';
}
$vertical_logo = cs_get_option( 'vertical_logo' );
$aside_open = cs_get_option('aside_open');



if(isset($meta_data['change_menu']) && $meta_data['change_menu'] && isset($meta_data['vertical_logo'])){
    $vertical_logo = $meta_data['vertical_logo'];
}

if(isset($meta_data['change_menu']) && $meta_data['change_menu'] && isset($meta_data['aside_open'])){
    $aside_open = $meta_data['aside_open'];
}


$aside_open = isset($aside_open) && $aside_open && $menu_main_style == 'aside' ? 'active-menu' : '';
$aside_open .= isset($vertical_logo) && $vertical_logo && $menu_main_style == 'aside' ? ' vertical' : '';
$menu_class = !function_exists( 'cs_framework_init' ) ? 'right-menu' : $menu_class;
$class_main_wrapper = '';
$menu_class = apply_filters( 'whizz_menu_style', $menu_class );
$bodyClass = apply_filters( 'whizz_body_class', $bodyClass );


$preloader_text = cs_get_option('preloader_text') ? cs_get_option('preloader_text') : 'w';
$preloader_images = cs_get_option('preloader_images') ? cs_get_option('preloader_images') : '';


// page options
$meta_data_portfolio = get_post_meta( get_the_ID(), 'whizz_portfolio_options', true );
$meta_data_events = get_post_meta( get_the_ID(), 'whizz_events_options', true );
$enable_footer_parallax = isset($meta_data['enable_parallax_footer_page']) ? $meta_data['enable_parallax_footer_page'] : cs_get_option( 'enable_parallax_footer' );
$enable_footer_parallax = apply_filters( 'whizz_blog_footer_style', $enable_footer_parallax );
$unitClass = !function_exists( 'cs_framework_init' ) ? ' unit ' : '';
$blog_type          = cs_get_option( 'blog_single_type' ) ? cs_get_option( 'blog_single_type' ) : 'modern';

if($enable_footer_parallax){
	$class_main_wrapper .= ' footer-parallax';
}


$class_desc_padd = '';
$class_mob_padd  = '';

if ( ! empty( $meta_data['padding_desktop'] ) ) {
	$class_desc_padd = ' padding-desc ';
}
if ( ! empty( $meta_data['padding_mobile'] ) ) {
	$class_mob_padd = ' padding-mob ';
}



$mobile = cs_get_option('mobile_menu');
$bodyClass .= isset($mobile) && $mobile ? ' mob-main-menu' : '';
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(	$bodyClass ); ?>>
<!-- MAIN_WRAPPER -->
<?php
$class_animsition = 'animsition' . $unitClass;
if (cs_get_option( 'whizz_disable_preloader') || cs_get_option('preloader_type') == 'text') {
	$class_animsition = '';
}

if(!cs_get_option( 'whizz_disable_preloader' ) && cs_get_option('preloader_type') == 'text'){ ?>
    <div class="preloader-svg">
        <svg id="loaderSvg" class="loader__svg" xmlns="http://www.w3.org/2000/svg" height="300" viewBox="0 0 1024 300" style="opacity: 1;">
		    <?php if(!empty($preloader_images)){?>
            <defs>
			    <?php
			    $preloader_images = explode(",", $preloader_images);
			    $count = 1;
			    foreach ( $preloader_images as $image ) { ?>
                    <pattern x="0" y="0" width="1024" height="686" patternUnits="userSpaceOnUse" id="pattern<?php echo esc_attr($count); ?>" viewBox="0 0 1024 300">
                        <image xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php echo esc_url(wp_get_attachment_image_url($image, 'large')); ?>" preserveAspectRatio="none" x="0" y="-200" width="1024" height="686"></image>
                    </pattern>
				    <?php $count++;
			    }?>
            </defs>
            <text x="50%" y="20%" id="letter" dy="150" style="text-anchor: middle; font-size: 180px; font-weight: bold;" fill="url('#pattern1')">
			    <?php }else{ ?>
                <text x="50%" y="20%" id="letter" dy="150" style="text-anchor: middle; font-size: 180px; font-weight: bold;" fill="#1b1b1b">
				    <?php } ?>
				    <?php echo esc_html($preloader_text); ?>
                </text>
        </svg>
    </div>
<?php } ?>

<div class="main-wrapper <?php echo esc_attr( $class_animsition . $class_main_wrapper) . ' ' . esc_attr( $class_desc_padd ) . esc_attr( $class_mob_padd ); ?>">
	<?php
	$fixed_menu_class = (cs_get_option( 'fixed_menu' ) || is_404()) && ($bodyClass != 'static-menu') ? ' enable_fixed' : '';

	if(($bodyClass != 'static-menu') && $menu_main_style != 'aside' && $menu_main_style != 'static_aside') {
		if ( isset( $meta_data['style_header'] ) && $meta_data['style_header'] === 'transparent' ) {
			$fixed_menu_class .= ' header_trans-fixed';
		} elseif ( isset( $meta_data_portfolio['style_header'] ) && $meta_data_portfolio['style_header'] === 'transparent' ) {
			$fixed_menu_class .= ' header_trans-fixed';
		} elseif ( is_404() || ( cs_get_option( 'fixed_transparent_menu_blog' ) && is_single() && get_post_type() == 'post' ) ) {
			$fixed_menu_class .= ' header_trans-fixed';
		} elseif ( cs_get_option( 'fixed_menu' ) && cs_get_option( 'transparent_menu' ) && ( ( isset( $meta_data['style_header'] ) && $meta_data['style_header'] === 'empty' ) || ( isset( $meta_data_portfolio['style_header'] ) && $meta_data_portfolio['style_header'] === 'empty' ) ) ) {
			$fixed_menu_class .= ' header_trans-fixed';
		} elseif ( ( isset( $meta_data['style_header'] ) && $meta_data['style_header'] === 'fixed' ) || ( isset( $meta_data_portfolio['style_header'] ) && $meta_data_portfolio['style_header'] === 'fixed' ) ) {
			$fixed_menu_class .= ' fixed-header';
		} elseif ( ( isset( $meta_data['style_header'] ) && $meta_data['style_header'] === 'none' ) || ( isset( $meta_data_portfolio['style_header'] ) && $meta_data_portfolio['style_header'] === 'none' ) ) {
			$fixed_menu_class .= ' header_trans-fixed none';
		} elseif ( isset( $meta_data_events['style_header'] ) && $meta_data_events['style_header'] === 'transparent' ) {
			$fixed_menu_class .= ' header_trans-fixed';
		} elseif ( cs_get_option( 'fixed_menu' ) && cs_get_option( 'transparent_menu' ) && isset( $meta_data_events['style_header'] ) && $meta_data_events['style_header'] === 'empty' ) {
			$fixed_menu_class .= ' header_trans-fixed';
		} elseif ( ( isset( $meta_data['style_header'] ) && $meta_data['style_header'] === 'fixed' ) || ( isset( $meta_data_events['style_header'] ) && $meta_data_events['style_header'] === 'fixed' ) ) {
			$fixed_menu_class .= ' fixed-header';
		} elseif ( ( isset( $meta_data['style_header'] ) && $meta_data['style_header'] === 'none' ) || ( isset( $meta_data_events['style_header'] ) && $meta_data_events['style_header'] === 'none' ) ) {
			$fixed_menu_class .= ' header_trans-fixed none';
		} else {
			$fixed_menu_class .= '';
		}
	}

	$fixed_menu_class = !function_exists( 'cs_framework_init' ) && is_404() ? ' fixed-header' : $fixed_menu_class;
	$fixed_menu_class = is_single() && get_post_type() == 'post' && $blog_type == 'modern' && !has_post_thumbnail() && !(isset( $post_meta[0]['post_preview_style'] ) && ( $post_meta[0]['post_preview_style'] != 'audio' || $post_meta[0]['post_preview_style'] != 'slider' || $post_meta[0]['post_preview_style'] != 'video' )) ? '' : $fixed_menu_class;
	$fixed_menu_class = apply_filters( 'whizz_blog_menu_style', $fixed_menu_class );
    $pad = $menu_class == 'right-menu aside-menu' || 'right-menu aside-menu vertical' ? 'style="padding-bottom: 0;"' : '';?>

	<div class="header_top_bg <?php echo esc_attr($fixed_menu_class) ?>" <?php echo $pad; ?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">

					<!-- HEADER -->
					<header class="<?php echo esc_attr( $menu_class . ' ' . $aside_open); ?>">
						<!-- LOGO -->
						<?php whizz_site_logo(); ?>
						<!-- /LOGO -->
                        <?php if(!($menu_main_style && ($menu_main_style == 'compact' || $menu_main_style == 'full' ))){ ?>
                            <!-- MOB MENU ICON -->
                            <a href="#" class="mob-nav">
                                <i class="fa fa-bars"></i>
                            </a>
                            <!-- /MOB MENU ICON -->
                        <?php } ?>


                        <!-- ASIDE MENU ICON -->
                        <a href="#" class="aside-nav">
                            <span class="aside-nav-line line-1"></span>
                            <span class="aside-nav-line line-2"></span>
                            <span class="aside-nav-line line-3"></span>
                        </a>
                        <!-- /ASIDE MOB MENU ICON -->

						<!-- NAVIGATION -->
						<nav id="topmenu" class="topmenu <?php echo esc_attr($aside_open); ?>">
                            <?php if($menu_main_style && $menu_main_style == 'full'){ ?>
                                <div class="full-menu-wrap">
                            <?php } ?>
                                <?php whizz_custom_menu(); ?>
                                <span class="f-right">
                                    <?php if ( cs_get_option( 'header_social' ) ) { ?>
                                        <div class="whizz-top-social">
                                            <span class="social-icon fa fa-share-alt"></span>
                                            <ul class="social">
                                                <?php foreach ( cs_get_option( 'header_social' ) as $link ) { ?>
                                                    <li><a href="<?php echo esc_url( $link['header_social_link'] ); ?>" target="_blank"><i class="<?php echo esc_attr( $link['header_social_icon'] ); ?>"></i></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php }

                                    if ( function_exists('WC') ) {
                                        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && (cs_get_option('shop_cart_on') || !function_exists( 'cs_framework_init' ) )) {

                                            $count = WC()->cart->cart_contents_count;
                                            ?>
                                            <div class="mini-cart-wrapper">
                                                <a class="whizz-shop-icon fa fa-shopping-bag" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart','whizz' ); ?>">
                                                    <?php  if ( $count > 0 ) {  ?>
                                                        <div class="cart-contents">
                                                            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
                                                        </div>
                                                    <?php } ?></a>
                                                <?php echo whizz_mini_cart(); ?>
                                            </div>
                                        <?php } }
                                    ?>
                                </span>
							<?php if($menu_main_style && $menu_main_style == 'full'){ ?>
                                </div>
							<?php } ?>
						</nav>
						<!-- NAVIGATION -->

						<?php if($menu_main_style && ($menu_main_style == 'compact' || $menu_main_style == 'full')){ ?>
                            <!-- MOB MENU ICON -->
                            <a href="#" class="mob-nav">
                                <i class="fa fa-bars"></i>
                            </a>
                            <!-- /MOB MENU ICON -->
						<?php } ?>

						<?php if ( cs_get_option( 'header_social' ) ||  function_exists('WC')) { ?>
                            <a href="#" class="socials-mob-but">
                                <i class="fa fa-share-alt"></i>
                            </a>
						<?php } ?>
					</header>
				</div>
			</div>

		</div>
	</div>