<?php
/**
 * Single
 *
 * @package whizz
 * @since 1.0
 *
 */
get_header();

$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}
$cs_sidebar = cs_get_option( 'sidebar' );

$post_meta = get_post_meta( $post->ID, 'whizz_post_options' );

$preview = isset( $post_meta[0]['post_preview_style'] ) ? $post_meta[0]['post_preview_style'] : '';

$unitClass = ! function_exists( 'cs_framework_init' ) ? 'unit' : '';

if ( get_post_type( $post->ID ) == 'proof_gallery' ) {
	$cs_sidebar = false;
}

$content_size_class = ( ! function_exists( 'cs_framework_init' ) || ( $cs_sidebar && in_array( 'post', $cs_sidebar ) ) ) ? 'col-md-9' : 'col-md-12';
$blog_type          = cs_get_option( 'blog_single_type' ) ? cs_get_option( 'blog_single_type' ) : 'modern';
$sidebar_class      = ! function_exists( 'cs_framework_init' ) || $cs_sidebar && in_array( 'blog', $cs_sidebar ) ? ' sidebar-show' : 'sidebar-no';

$singleClass = $blog_type == 'classic' && $sidebar_class == ' sidebar-show' ? ' pr30 ' : '';

while ( have_posts() ) :
	the_post();
	?>

<div class="post-details <?php echo esc_attr( $unitClass . ' ' . $preview ); ?>">
	<?php
	if ( ! ( ! has_post_thumbnail() && $blog_type == 'modern' ) && function_exists( 'cs_framework_init' ) ) {
		if ( ( has_post_thumbnail() || isset( $post_meta[0]['post_preview_style'] ) ) && ! ( get_post_type( $post->ID ) == 'proof_gallery' || get_post_type( $post->ID ) == 'whizzy_proof_gallery' ) ) { ?>
            <div class="post-banner">
				<?php if ( isset( $post_meta[0]['post_preview_style'] ) && $post_meta[0]['post_preview_style'] != 'text' && $post_meta[0]['post_preview_style'] != 'image' && ( get_post_format( $post->ID ) != 'quote' ) || ! isset( $post_meta[0]['post_preview_style'] ) && function_exists( 'cs_framework_init' ) ) {
					$video_params = array(
						'enablejsapi'    => 1,
						'loop'           => 1,
						'autoplay'       => 1,
						'controls'       => 0,
						'showinfo'       => 0,
						'modestbranding' => 0,
						'rel'            => 0,
					);
					whizz_blog_item_hedeader( $post_meta, $post->ID, $video_params, 'start', 'play' );
				} elseif ( has_post_thumbnail() ) {
					$tumb_url = get_the_post_thumbnail_url( $post->ID, 'full' ); ?>
                    <img src="<?php echo esc_url( $tumb_url ); ?>" alt="" class="s-img-switch">
				<?php } ?>
                <div class="main-top-content text-center">
					<?php the_title( '<h2 class="title">', '</h2>' ); ?>
                    <div class="date-post"><?php the_time( get_option( 'date_format' ) ); ?></div>
					<?php if ( cs_get_option( 'whizz_post_author' ) ) { ?>
                        <div class="author"><?php esc_html_e( 'Written by: ', 'whizz' );
							the_author_link(); ?></div>
					<?php } ?>
                </div>
            </div>
            </div>

			<?php
		}
	}
	if ( $blog_type == 'modern' ) { ?>

		<?php if ( ! has_post_thumbnail() || ! function_exists( 'cs_framework_init' ) || get_post_type( $post->ID ) == 'proof_gallery' || get_post_type( $post->ID ) == 'whizzy_proof_gallery' ) { ?>

            <div class="post-little-banner">
                <div class="main-top-content text-center">
					<?php the_title( '<h2 class="title">', '</h2>' ); ?>
                    <div class="date-post"><?php the_time( get_option( 'date_format' ) ); ?></div>
					<?php if ( cs_get_option( 'whizz_post_author' ) ) { ?>
                        <div class="author"><?php esc_html_e( 'Written by: ', 'whizz' );
							the_author_link(); ?></div>
					<?php } ?>
                </div>
            </div>
		<?php } ?>

        <div class="post-paper <?php echo esc_attr( $sidebar_class . ' ' . $blog_type ); ?>">
	<?php } ?>

    <div class="container">
        <div class="row">
            <div class="single-content no-padd-md <?php echo esc_attr( $protected . $singleClass . ' ' . $content_size_class ); ?>">

                <?php if($blog_type !== 'modern' ){ ?>
                    <div class="wrap-fix">
                <?php }

                the_content();

                wp_link_pages( 'link_before=<span class="pages">&link_after=</span>&before=<div class="post-nav"> <span>' . esc_html__( "Page:", 'whizz' ) . ' </span> &after=</div>' );

                if($blog_type !== 'modern' ){ ?>
                    </div>
                <?php }

                if ( ! function_exists( 'cs_framework_init' ) || cs_get_option( 'whizz_post_tags' ) || cs_get_option( 'whizz_post_cat' ) ) { ?>
                    <div class="post-info">
						<?php if ( ! function_exists( 'cs_framework_init' ) || cs_get_option( 'whizz_post_cat' ) ) { ?>
                            <span><?php esc_html_e( 'Categories: ', 'whizz' );
								the_category( ' ' ); ?></span>
						<?php }
						if ( ! function_exists( 'cs_framework_init' ) || cs_get_option( 'whizz_post_tags' ) ) { ?>
                            <span><?php the_tags( 'Tags: ', ' ' ); ?></span>
						<?php } ?>
                    </div>
				<?php }

				if ( cs_get_option( 'whizz_social_post' ) ) { ?>
                    <div class="ft-part">
                        <ul class="social-list">
                            <li><?php esc_html_e( 'Share:', 'whizz' ); ?></li>
                            <li>
                                <a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
                                   target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                            <li>
                                <a href="http://pinterest.com/pin/create/link/?url=<?php echo esc_url( urlencode( get_permalink() ) ); ?>&amp;media=<?php echo esc_attr( $pinterestimage[0] ); ?>&amp;description=<?php esc_attr( the_title() ); ?>"
                                   class="pinterest" target="_blank" title="Pin This Post"><i
                                            class="fa fa-pinterest-p"></i></a></li>
                            <li>
                                <a href="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>&amp;t=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
                                   class="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li>
                                <a href="http://twitter.com/home?status=<?php echo esc_url( urlencode( the_title( '', '', false ) ) ); ?><?php esc_url( the_permalink() ); ?>"
                                   class="twitter" target="_blank" title="Tweet"><i
                                            class="fa fa-twitter"></i></a></li>
                            <li>
                                <a href="http://plus.google.com/share?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
                                   target="_blank" class="gplus"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
				<?php }

				$my_cat = get_query_var( 'cat' );

				$args = array(
					'posts_per_page'      => 3,
					'cat'                 => $my_cat,
					'orderby'             => 'date',
					'order'               => 'DESC',
					'ignore_sticky_posts' => true,
					'post__not_in'        => array( $post->ID )
				);


				$query = new WP_Query( $args );


				if ( $query->have_posts() ) {
					if ( function_exists( 'cs_framework_init' ) ) { ?>
                        <div class="recent-post-single clearfix">
                            <div class="row margin-lg-110t margin-sm-70t margin-xs-40t">
								<?php while ( $query->have_posts() ) {
									$query->the_post();
									$imagerec = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );

									$no_image = ! has_post_thumbnail() ? ' no-image' : ''; ?>

                                    <div class="col-sm-4 margin-xs-30b recent-simple-post <?php echo esc_html( $no_image ); ?>">
                                        <div class="sm-wrap-post">
                                            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"
                                               class="img s-back-switch">
                                                <div class="back"></div>
												<?php
												echo whizz_the_lazy_load_flter(
													$imagerec[0],
													array( 'class' => 's-img-switch', 'alt' => '' )
												);
												?>
                                            </a>
                                            <div class="content">
                                                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"
                                                   class="title"><?php echo esc_html( $post->post_title ); ?></a>
                                                <div class="excerpt"><?php echo esc_html( $post->post_excerpt ); ?></div>
                                                <div class="post-date"><span
                                                            class="date"><?php echo esc_html( get_the_time( get_option( 'date_format' ), $post->ID ) ); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?php
								} ?>
                            </div>
                        </div>
					<?php }
				}
				wp_reset_postdata();


				if ( ! function_exists( 'cs_framework_init' ) || ( cs_get_option( 'whizz_navigation_posts' ) && ! isset( $post_meta[0]['whizz_navigation_posts'] ) )
				     || ( isset( $post_meta[0]['whizz_navigation_posts'] ) && $post_meta[0]['whizz_navigation_posts'] ) ) { ?>
                    <div class="single-pagination">
						<?php
						$prev_post = get_previous_post();
						if ( ! empty( $prev_post ) ) : ?>
                            <div class="pag-prev">
                                <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="content">
									<?php esc_html_e( 'Previous post', 'whizz' ); ?>
                                </a>
                            </div>
						<?php endif;
						$next_post = get_next_post();
						if ( ! empty( $next_post ) ) :
							?>
                            <div class="pag-next">
                                <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="content">
									<?php esc_html_e( 'Next post', 'whizz' ); ?>
                                </a>
                            </div>
						<?php endif; ?>
                    </div>
					<?php
				} ?>
				<?php if ( comments_open() || '0' != get_comments_number() && wp_count_comments( $post->ID ) ) { ?>
                    <ul class="comments main">
						<?php comments_template( '', true ); ?>
                    </ul>
				<?php } ?>

            </div>
			<?php if ( ! function_exists( 'cs_framework_init' ) || ( $cs_sidebar && in_array( 'post', $cs_sidebar ) ) ) { ?>
                <div class="col-md-3 pl30md">
				<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'sidebar' ) ) ?>
                    </div>
				<?php } ?>
        </div>
    </div>
	<?php

	if ( $blog_type == 'modern' ) { ?>
        </div>
	<?php }

	if ( get_post_type( $post->ID ) == 'proof_gallery' ) { ?>
        </div>
	<?php }

endwhile;

$username = cs_get_option( 'insta_username' );
$count    = cs_get_option( 'insta_count' ) ? cs_get_option( 'insta_count' ) : '21';
if ( ! empty( $username ) && cs_get_option( 'instagram_page_blog_detail' ) ) { ?>
    <div class="container-fluid no-padd">
        <div class="row">
			<?php if ( ! empty( $username ) && ! empty( $count ) ) {
				$token_switch     = cs_get_option( 'insta_token_switcher' );
				$instagram_images = whizz_get_imstagram( $username, $count ); ?>

                <div class="insta-box margin-lg-35t margin-xs-15t col-xs-12">
					<?php if ( ! empty( $username ) ) { ?>
                        <div class="insta-box-follow"><a
                                    href="https://instagram.com/<?php echo esc_attr( $username ); ?>" class="insta-acc">@<?php echo esc_html( $username ); ?></a>
                        </div>
					<?php } ?>
                    <div class="insta-img-wrap gridrotate">
                        <ul>
							<?php if ( ! empty( $instagram_images ) ) {
								foreach ( $instagram_images as $image ) {
									$image_url = ( $token_switch && isset( $image['image-url'] ) ) ? $image['image-url'] : $image['large']; ?>
                                    <li>
                                        <span>
                                            <img src="<?php echo esc_url( $image_url ); ?>" alt="">
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











