<?php
/**
 * Index Page
 *
 * @package whizz
 * @since 1.0
 *
 */

$content_size_class = !function_exists( 'cs_framework_init' )  || cs_get_option( 'sidebar' ) && in_array( 'blog', cs_get_option( 'sidebar' ) ) ? ' col-md-9' : '';
$sidebar_class = !function_exists( 'cs_framework_init' )  || cs_get_option( 'sidebar' ) && in_array( 'blog', cs_get_option( 'sidebar' ) ) ? ' sidebar-show' : 'sidebar-no';
$post_size_class    = !function_exists( 'cs_framework_init' ) && cs_get_option( 'sidebar' ) && in_array( 'blog', cs_get_option( 'sidebar' ) ) ? 6 : 4;
$blog_type = cs_get_option('blog_type') ? cs_get_option('blog_type') : 'modern';
$blog_categories = cs_get_option('blog_categories_show') && cs_get_option('blog_categories') ? cs_get_option('blog_categories') : '';
$blog_type = apply_filters( 'whizz_blog_style', $blog_type );
$title = cs_get_option('blog_title') ? cs_get_option('blog_title') : esc_html__('Blog', 'whizz');
if($blog_type == 'modern'){
	$content_size_class .= function_exists( 'cs_framework_init' ) && !cs_get_option('show_big_letter') ? '' : ' not-letter';
}


get_header(); ?>
<?php if ( have_posts() ) : ?>
     <?php if($blog_type == 'modern' || $blog_type == 'grid_letter'){ ?>
        <div class="post-little-banner">
            <h3 class="page-title-blog"><?php echo esc_html($title); ?></h3>
        </div>
        <div class="post-paper <?php echo esc_attr($sidebar_class . ' ' . $blog_type); ?>">
    <?php } ?>

	<div class="container">
		<div class="row">
			<div class="blog<?php echo esc_attr( $content_size_class ); ?> no-padd">
				<div class="row">
					<?php

					$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

					$args = array(
						'post_type'    => 'post',
						'paged'        => $paged,
					);
					$blog_categories = apply_filters( 'whizz_blog_cat_style', $blog_categories );

					if(isset($_GET['blog_style']) && $_GET['blog_style'] == 'squares'){
						$args['posts_per_page'] = '12';
					}

					if ( ! empty($blog_categories ) ) {

						$cats = array();

						foreach ( $blog_categories as $term_slug ) {
							$term_info = get_term_by( 'slug', $term_slug, 'category' );
							$cats[]    = $term_info->term_id;

						}
						$args['category__in'] = $cats;
					}

					$posts = new WP_Query( $args );

					while ( $posts->have_posts() ) : $posts->the_post();
						$no_image = !has_post_thumbnail() ? ' no-image' : '';
						$post_options = get_post_meta( get_the_ID(), 'whizz_post_options' );
						$preview = isset($post_options[0]['post_preview_style']) ? $post_options[0]['post_preview_style'] : 'noo';
						if($blog_type == 'grid'){ ?>
                            <div class="post col-md-<?php echo esc_attr( $post_size_class . ' ' . $no_image ); ?> col-sm-6">
                                <div class="post-wrap-item <?php echo esc_attr($preview); ?>">
									<?php if ( isset( $post_options[0]['post_preview_style'] ) && $post_options[0]['post_preview_style'] != 'text' && ( get_post_format( get_the_ID() ) != 'quote' ) || ! isset( $post_options[0]['post_preview_style'] ) ) {
										whizz_blog_item_hedeader( $post_options, get_the_ID() );
									} ?>
                                    <a href="<?php the_permalink(); ?>" <?php post_class( 'post-content'); ?>>
										<?php the_title( '<h5 class="title">', '</h5>' ); ?>
                                        <p class="date"><?php the_time( get_option( 'date_format' ) ); ?></p>
										<?php if ( isset( $post_options[0]['post_preview_style'] ) && $post_options[0]['post_preview_style'] == 'text' || ( get_post_format( get_the_ID() ) == 'quote' ) ) {
											whizz_blog_item_hedeader( $post_options, get_the_ID() );
										} ?>
                                    </a>
                                </div>
                            </div>
                        <?php }
                        elseif($blog_type == 'modern'){
						    if(has_post_thumbnail()){ ?>
                                <div <?php post_class( 'classic post col-xs-12'); ?>>
                                    <div class="post-content">
									    <?php $title = get_the_title();
									    if(!empty($title)){ ?>
                                            <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
									    <?php }?>
                                        <div class="post-info-modern">

                                            <span class="author"><?php echo esc_html_e('By ', 'whizz'); the_author_posts_link(); ?></span>
                                            <span class="category"><?php the_category( ' ' ); ?></span>
                                            <span class="date"><a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
                                        </div>
                                    </div>
								    <?php the_post_thumbnail( 'full', array('class' => 'main-img') ); ?>
                                    <div class="post-description">
									    <?php the_excerpt(); ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="a-btn-2"><?php echo esc_html_e('Read on', 'whizz'); ?><i class="fa fa-caret-right" aria-hidden="true"></i></a>
                                </div>
                            <?php }else{ ?>
                                <div <?php post_class($blog_type . ' post col-xs-12'); ?>>
								    <?php $title = get_the_title(); ?>
                                    <div class="post-content">
									    <?php if(!empty($title)){ ?>
                                            <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                                            <?php if(function_exists( 'cs_framework_init' ) && !cs_get_option('show_big_letter')){ ?>
                                                <span class="post-big-letter"><?php echo esc_html($title{0}); ?></span>
                                            <?php } ?>
									    <?php }?>
                                        <div class="post-info-modern">
                                            <span class="author"><?php echo esc_html_e('By ', 'whizz'); the_author_posts_link(); ?></span>
										    <?php if(get_the_category()){ ?>
                                                <span class="category"><?php the_category( ' ' ); ?></span>
										    <?php  } ?>
                                            <span class="date"><a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
                                        </div>
                                    </div>
                                    <div class="post-description">
									    <?php the_excerpt(); ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="a-btn-2"><?php echo esc_html_e('Read on', 'whizz'); ?><i class="fa fa-caret-right" aria-hidden="true"></i></a>
                                </div>
                            <?php } ?>
                        <?php }
                        elseif($blog_type == 'grid_letter'){?>
                        <div <?php post_class($blog_type . ' classic item post col-xs-12 col-sm-6'); ?>>
                        <div class="post-content">
                        <?php $title = get_the_title();
                        if(!empty($title)){ ?>
                        <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                        <span class="post-big-letter"><?php echo esc_html($title{0}); ?></span>
                        <?php }?>
                        <div class="post-info-modern">
                        <span class="date"><a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
                        </div>
                        </div>
                        </div>
                        <?php }
                        elseif($blog_type == 'squares'){ ?>
                            <div class="post squares col-xs-12 no-padd col-md-3 <?php echo esc_attr( $no_image ); ?> col-sm-6">
                                <div class="post-wrap-item <?php echo esc_attr($preview); ?>">
                                    <?php if ( isset( $post_options[0]['post_preview_style'] ) && $post_options[0]['post_preview_style'] != 'text' && ( get_post_format( get_the_ID() ) != 'quote' ) || ! isset( $post_options[0]['post_preview_style'] ) ) {
                                    whizz_blog_item_hedeader( $post_options, get_the_ID() );
                                    } ?>
                                    <a href="<?php the_permalink(); ?>" <?php post_class( 'post-content'); ?>>
                                        <?php the_title( '<h5 class="title">', '</h5>' ); ?>
                                        <p class="date"><?php the_time( get_option( 'date_format' ) ); ?></p>
                                        <?php if ( isset( $post_options[0]['post_preview_style'] ) && $post_options[0]['post_preview_style'] == 'text' || ( get_post_format( get_the_ID() ) == 'quote' ) ) {
                                        whizz_blog_item_hedeader( $post_options, get_the_ID() );
                                        } ?>
                                    </a>
                                </div>
                            </div>
                        <?php }?>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<div class="pager-pagination">
					<?php
                    echo paginate_links( array(
	                    'total'   => $posts->max_num_pages,
	                    'prev_text' => __('<i class="fa fa-caret-left" aria-hidden="true"></i> Previous', 'whizz'),
	                    'next_text' => __('Next <i class="fa fa-caret-right" aria-hidden="true"></i>', 'whizz'),
                    ) ); ?>
				</div>
			</div>
			<?php if ( ! function_exists( 'cs_framework_init' ) || cs_get_option( 'sidebar' ) && in_array( 'blog', cs_get_option( 'sidebar' ) ) ) { ?>
				<div class="col-md-3 pl30md">
					<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'sidebar' ) ) {
					} ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php if($blog_type == 'modern' || $blog_type == 'grid_letter'){ ?>
        </div>
    <?php } ?>

<?php else : ?>
    <?php if($blog_type == 'modern' || $blog_type == 'grid_letter'){ ?>
        <div class="post-little-banner">
            <h3 class="page-title-blog"><?php echo esc_html($title); ?></h3>
        </div>
        <div class="post-paper <?php echo esc_attr($sidebar_class . ' ' . $blog_type); ?>">
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="empty-post-list">
		            <h3><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'whizz' ); ?></h3>
		            <?php get_search_form( true ); ?>
                </div>
            </div>
        </div>
    </div>
	<?php if($blog_type == 'modern' || $blog_type == 'grid_letter'){ ?>
        </div>
	<?php } ?>
<?php endif;


$username = cs_get_option('insta_username');
$count    = cs_get_option('insta_count') ? cs_get_option('insta_count') : '21';

if(!empty($username) && cs_get_option('instagram_page_blog')){ ?>
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
