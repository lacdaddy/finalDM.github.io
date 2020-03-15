<?php
/**
 * Single portfolio
 *
 * @package whizz
 * @since 1.0
 *
 */
get_header();

$protected = '';

if (post_password_required()) {
    $protected = 'protected-page';
}

$popup_thumb = cs_get_option('popup_thumb');
$popup_thumb = isset($popup_thumb) ? $popup_thumb : 'true';
$popup_thumb = $popup_thumb == '1' && $popup_thumb == 'true' ? 'true' : 'false';

$portfolio_meta = get_post_meta($post->ID, 'whizz_portfolio_options');

$portfolio_meta[0]['portfolio_style'] = !empty($portfolio_meta[0]['portfolio_style']) ? $portfolio_meta[0]['portfolio_style'] : 'classic';

$size_images = 'full';
if (isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 1) {
    $size_images = 'thumbnail';
} elseif (isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 2) {
    $size_images = 'medium';
} elseif (isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 3) {
    $size_images = 'medium_large';
} elseif (isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 4) {
    $size_images = 'large';
}

$columnsclass = isset($portfolio_meta[0]['columns_number']) ? $portfolio_meta[0]['columns_number'] : '';
$space = isset($portfolio_meta[0]['space']) && !empty($portfolio_meta[0]['space']) ? $portfolio_meta[0]['space'] : 15;

if (!empty($columnsclass) && $columnsclass != 'four') {
    $columnsclass = $columnsclass == 'three' ? 'col-3' : 'col-6';
} else {
    $columnsclass = 'col-4';
}

$columns_number = isset($portfolio_meta[0]['columns_number']) ? $portfolio_meta[0]['columns_number'] : '';

$hover_style = isset($portfolio_meta[0]['hover_style']) ? $portfolio_meta[0]['hover_style'] : 'default';


while (have_posts()) : the_post(); ?>

    <?php if ($portfolio_meta[0]['portfolio_style'] == 'paralax' && !post_password_required($post)) { ?>
        <div class="container-fluid no-padd portfolio-single-content parallax <?php echo esc_attr($protected); ?>">
    <?php } else { ?>
        <div class="container clearfix no-padd portfolio-single-content margin-lg-30b <?php echo esc_attr($protected); ?>">
    <?php }

    if(!post_password_required($post)){?>
    <div class="row">
        <div class="col-xs-12">
            <?php the_content(); ?>
        </div>
    </div>
    <?php }
    
    if (post_password_required($post)) {
        if(cs_get_option('portfolio_protect_title')) { ?>
            <h3 class="protected-title"><?php echo esc_html(cs_get_option('portfolio_protect_title')); ?></h3>
        <?php the_content();
        }
    }
    elseif (!empty($portfolio_meta[0]['slider'])) {

        $images = explode(',', $portfolio_meta[0]['slider']);

        if (cs_get_option('social_portfolio')) {
                if (!empty($portfolio_meta[0]['whizz_social_portfolio'])) { ?>
                    <div class="row single-share">
                        <div class="ft-part margin-lg-15b">
                            <ul class="social-list">
                                <li><span><?php esc_html_e('Share:', 'whizz'); ?></span></li>
                                <li>
                                    <a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php esc_url(the_permalink()); ?>&amp;title=<?php echo esc_attr(urlencode(the_title('', '', false))); ?>"
                                       target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                                <li>
                                    <a href="http://pinterest.com/pin/create/link/?url=<?php echo esc_url(urlencode(get_permalink())); ?>&amp;description=<?php esc_attr(the_title()); ?>"
                                       class="pinterest" target="_blank" title="Pin This Post"><i
                                            class="fa fa-pinterest-p"></i></a></li>
                                <li>
                                    <a href="http://www.facebook.com/sharer.php?u=<?php esc_url(the_permalink()); ?>&amp;t=<?php echo esc_attr(urlencode(the_title('', '', false))); ?>"
                                       class="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li>
                                    <a href="http://twitter.com/home?status=<?php echo esc_attr(urlencode(the_title('', ' ', false))); ?><?php esc_url(the_permalink()); ?>"
                                       class="twitter" target="_blank" title="Tweet"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="http://plus.google.com/share?url=<?php esc_url(the_permalink()); ?>&amp;title=<?php echo esc_attr(urlencode(the_title('', '', false))); ?>"
                                       target="_blank" class="gplus"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                <?php }
            }

        if ($portfolio_meta[0]['portfolio_style'] == 'classic') { ?>

            <div class="container clearfix no-padd">
                <div class="gallery-single margin-lg-10b margin-xs-0b <?php echo esc_attr($columnsclass); ?>" data-thumb="<?php echo esc_attr($popup_thumb); ?>" data-space="<?php echo esc_attr($space); ?>">
                    <div class="izotope-container">
                        <div class="grid-sizer"></div>
                        <?php $counter = 0;
                        foreach ($images as $image) {
                            $url = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';
                            $url_size = (is_numeric($image) && !empty($image)) ? wp_get_attachment_image_src($image, $size_images) : '';
                            $attachment = get_post($image);
                            $title = $attachment->post_excerpt;
                            $hover_style = $hover_style == 'slip' ? 'slip' : ''; ?>

                            <div class="item-single">
                                    <a href="<?php echo esc_url($url); ?>" class="gallery-item <?php echo esc_attr($columns_number . ' ' . $hover_style); ?>">
                                       <?php echo whizz_the_lazy_load_flter($url_size[0], array(
                                            'class' => 's-img-switch',
                                            'alt' => $attachment->post_excerpt
                                        )); ?>

                                        <div class="info-content"
                                             data-content="<?php echo wp_kses_post($attachment->post_excerpt); ?>">
                                            <div class="vertical-align">
                                                <?php if (!empty($attachment->post_excerpt)) { ?>
                                                    <h5><?php echo wp_kses_post($attachment->post_excerpt); ?></h5>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </a>
                            </div>
                            <?php $counter++;
                        } ?>
                    </div>
                </div>
            </div>
        <?php } elseif ($portfolio_meta[0]['portfolio_style'] == 'modern' || $portfolio_meta[0]['portfolio_style'] == 'pinterest') {

            $wrap_class = '';
            if (!empty($portfolio_meta[0]['num_show_img'])) {
                $wrap_class = ' counter-wrap-port';
            } ?>

            <div class="container clearfix no-padd <?php echo esc_attr($wrap_class); ?>">
                <div class="gallery-single margin-lg-10b margin-xs-0b <?php echo esc_attr($columnsclass); ?>" data-thumb="<?php echo esc_attr($popup_thumb); ?>" data-space="<?php echo esc_attr($space); ?>">
                    <div class="izotope-container">
                        <div class="grid-sizer"></div>
                        <?php
                        $counter = 0;
                        foreach ($images as $image) {
                            $url = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';
                            $url_size = (is_numeric($image) && !empty($image)) ? wp_get_attachment_image_src($image, $size_images) : '';
                            $attachment = get_post($image);
                            $title = $attachment->post_excerpt;
                            $hover_style = $hover_style == 'slip' ? 'slip' : '';


                            if (isset($portfolio_meta[0]['num_show']) && $portfolio_meta[0]['num_show'] == true && !empty($portfolio_meta[0]['num_show_img']) && $counter < ($portfolio_meta[0]['num_show_img'])) {
                                $count_class = ' count-show';
                            } else {
                                $count_class = '';
                            }

                            if($portfolio_meta[0]['portfolio_style'] == 'pinterest'){
	                            $count_class .= ' modern';
                            } ?>

                            <div class="<?php echo esc_attr($portfolio_meta[0]['portfolio_style']) . esc_attr($count_class); ?> item-single ">
                                    <a href="<?php echo esc_url($url); ?>" class="gallery-item modern <?php echo esc_attr($hover_style); ?>" data-src="<?php echo esc_attr( $url_size[0] ); ?>">
                                        <?php echo whizz_the_lazy_load_flter($url_size[0], array(
                                            'class' => '',
                                            'alt' => $attachment->post_excerpt
                                        )); ?>

                                        <div class="info-content">
                                            <div class="vertical-align">
                                                <?php if (!empty($attachment->post_excerpt) && $portfolio_meta[0]['portfolio_style'] != 'pinterest') { ?>
                                                    <h5><?php echo wp_kses_post($attachment->post_excerpt); ?></h5>
                                                <?php }else{ ?>
                                                    <h5></h5>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </a>
                            </div>

                            <?php $counter++;
                        } ?>
                    </div>
                </div>

                <?php if (isset($portfolio_meta[0]['num_show']) && $portfolio_meta[0]['num_show'] == true && !empty($portfolio_meta[0]['num_show_img'])) { ?>
                    <div class="row margin-lg-60t margin-sm-30t text-center">
                        <a href="#" class="portfolio-load-more a-btn-2"
                           data-num="<?php echo esc_attr($portfolio_meta[0]['num_show_img']); ?>"><?php echo esc_html__('load more', 'whizz'); ?></a>
                    </div>
                <?php } ?>
            </div>

        <?php } elseif ($portfolio_meta[0]['portfolio_style'] == 'paralax') {

            $count = 0;
            foreach ($images as $image) {
                $url = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';
                $url_size = (is_numeric($image) && !empty($image)) ? wp_get_attachment_image_src($image, $size_images) : '';
                $attachment = get_post($image); ?>

                <div class="parallax-window full-height" data-parallax="scroll" data-position-Y="top"
                     data-image-src="<?php echo esc_url($url_size[0]); ?>">
                    <?php
                    if ($count == 0) { ?>
                        <div class="content-parallax">
                            <div class="category-parallax">
                                <?php the_terms(get_the_ID(), 'portfolio-category'); ?>
                            </div>
                            <?php the_title('<h3 class="title">', '</h3>'); ?>
                        </div>
                    <?php } ?>
                </div>
                <?php
                $count++;
            }
        }
    }

    if (cs_get_option('navigation_portfolio')) {
        if (isset($portfolio_meta[0]['whizz_navigation_portfolio']) && $portfolio_meta[0]['whizz_navigation_portfolio']) { ?>
            <div class="container">
                <div class="row">
                    <div class="single-pagination">
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty($prev_post)) :
                            ?>
                            <div class="pag-prev">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="content">
                                    <?php esc_html_e('Previous gallery', 'whizz'); ?>
                                </a>
                            </div>
                        <?php endif;
                        $next_post = get_next_post();
                        if (!empty($next_post)) :
                            ?>
                            <div class="pag-next">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="content">
                                    <?php esc_html_e('Next gallery', 'whizz'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php }

    } ?>

    </div>
    <?php
endwhile;

    $username = cs_get_option('insta_username');
    $count    = cs_get_option('insta_count') ? cs_get_option('insta_count') : '21';

    if(!empty($username) && cs_get_option('instagram_page_portfolio_detail')){ ?>
        <div class="container-fluid no-padd">
            <div class="row">
			    <?php if ( ! empty( $username ) && ! empty( $count ) ) {
			        $token_switch = cs_get_option('insta_token_switcher');
				    $instagram_images = whizz_get_imstagram( $username, $count ); ?>

				   <div class="insta-box margin-lg-35t margin-xs-15t col-xs-12">
					   <?php if ( ! empty( $username ) ) { ?>
					        <div class="insta-box-follow"><a href="https://instagram.com/<?php echo esc_attr($username); ?>" class="insta-acc">@<?php echo esc_html( $username ); ?></a></div>
					   <?php } ?>
				            <div class="insta-img-wrap gridrotate">
				                <ul>
	                            <?php if ( ! empty( $instagram_images ) ) {
                                    foreach ( $instagram_images as $image ) {
                                        $image_url = ( $token_switch && isset( $image['image-url'] ) ) ? $image['image-url'] : $image['large']; ?>
                                       <li>
                                            <span>
                                                <img src="<?php echo esc_url($image_url); ?>" alt="" >
                                            </span>
                                        </li>
                                    <?php }
				                } ?>
				                </ul>
				            </div>
				        </div>
			        <?php } ?>
                </div>
            </div>
        <?php }

get_footer(); 