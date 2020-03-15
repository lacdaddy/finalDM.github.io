<?php
/**
 * Template Name: Modern Page
 *
 * @package whizz
 * @since 1.0
 *
 */
get_header();
$page_meta = get_post_meta( $post->ID, '_custom_page_options' );
$page_template_meta = get_post_meta( $post->ID, '_custom_template_page_options' );

$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}
$content_size_class = ( is_active_sidebar( 'modern_sidebar' ) && $page_template_meta[0]['template_sidebar'] != 'none') ? 'col-md-9' : 'col-md-12';

while ( have_posts() ) : the_post();
	$content = get_the_content();
	if ( ! strpos( $content, 'vc_' ) ) { ?>
		<div class="single-content modern">
            <div class="container <?php echo esc_attr( $protected ); ?>">
                <div class="row content-header">
                    <div class="col-xs-12 text-center">
                        <?php if ( !post_password_required() ) {
                            the_title( '<h3 class="title">', '</h3>' );
                        } ?>
                    </div>
                </div>
                <?php if(!empty($page_template_meta[0]['additional_text'])){ ?>
                    <div class="row content-header text-center">
                        <div class="col-xs-12">
			                <div class="description">
				                <?php echo do_shortcode($page_template_meta[0]['additional_text']); ?>
                            </div>
                        </div>
                    </div>
                <?php }?>
	            <?php if(!empty($page_template_meta[0]['image_page'])){ ?>
                    <div class="row content-header text-center">
                        <div class="col-xs-12">
                            <img src="<?php echo esc_url($page_template_meta[0]['image_page']); ?>" alt="">
                        </div>
                    </div>
	            <?php }?>
                <div class="row main-template-content">
	                <?php if ( is_active_sidebar( 'modern_sidebar' ) && $page_template_meta[0]['template_sidebar'] == 'left') { ?>
                        <div class="col-xs-12 col-md-3 pr30md ">
		                <?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'modern_sidebar' ) ) ?>
                            </div>
		                <?php } ?>
                    <div class="col-xs-12 <?php echo esc_attr($content_size_class); ?>">
                        <?php if ( post_password_required() ) { ?>
                                <?php the_title( '<h3 class="title protected-title">', '</h3>' ); ?>
                            <?php }
                            the_content(); ?>
                    </div>

                    <?php if ( is_active_sidebar( 'modern_sidebar' ) && $page_template_meta[0]['template_sidebar'] == 'right') { ?>
                        <div class="col-xs-12 col-md-3 pl30md margin-sm-30t">
                            <?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'modern_sidebar' ) ) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            if(!empty($page_template_meta[0]['insta_username'])){ ?>
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
            <?php } ?>
		</div>
	<?php } else {
	    $class_container = !empty($page_meta[0]['disable_container_padding']) ? ' no-padd' : '';  ?>
        <div class="single-content modern">
            <div class="container <?php echo esc_attr( $protected ); ?>">
                <div class="row content-header">
                    <div class="col-xs-12 text-center">
						<?php if ( !post_password_required() ) {
							the_title( '<h3 class="title">', '</h3>' );
						} ?>
                    </div>
                </div>
				<?php if(!empty($page_template_meta[0]['additional_text'])){ ?>
                    <div class="row content-header text-center">
                        <div class="col-xs-12">
                            <div class="description">
								<?php echo do_shortcode($page_template_meta[0]['additional_text']); ?>
                            </div>
                        </div>
                    </div>
				<?php }?>
				<?php if(!empty($page_template_meta[0]['image_page'])){ ?>
                    <div class="row content-header text-center">
                        <div class="col-xs-12">
                            <img src="<?php echo esc_url($page_template_meta[0]['image_page']); ?>" alt="">
                        </div>
                    </div>
				<?php }?>
                <div class="row main-template-content">
					<?php if ( is_active_sidebar( 'modern_sidebar' ) && $page_template_meta[0]['template_sidebar'] == 'left') { ?>
                        <div class="col-xs-12 col-md-3 pr30md ">
						<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'modern_sidebar' ) ) ?>
                            </div>
						<?php } ?>
                    <div class="col-xs-12 <?php echo esc_attr($content_size_class); ?>">
						<?php if ( post_password_required() ) { ?>
							<?php the_title( '<h3 class="title protected-title">', '</h3>' ); ?>
						<?php }
						the_content(); ?>
                    </div>

					<?php if ( is_active_sidebar( 'modern_sidebar' ) && $page_template_meta[0]['template_sidebar'] == 'right') { ?>
                        <div class="col-xs-12 col-md-3 pl30md margin-sm-30t">
						<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'modern_sidebar' ) ) ?>
                            </div>
						<?php } ?>
                </div>
            </div>
        </div>
	<?php }
endwhile;
get_footer();