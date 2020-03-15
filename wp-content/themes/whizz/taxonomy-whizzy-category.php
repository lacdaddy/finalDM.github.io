<?php
/**
 * The template for displaying archive pages.
 *
 * @package fcampaign
 * @since 1.0.0
 *
 */

get_header();

// Category taxonomy
global $wp_query;
$tax = $wp_query->get_queried_object();


// Posts args
$args = array(
	'posts_per_page' => - 1,
	'post_type'      => 'whizzy_proof_gallery',
	'tax_query'      => array(
		array(
			'taxonomy' => 'whizzy-category',
			'field'    => 'slug',
			'terms'    => $tax->slug
		)
	)
);

$portfolioCategory = new WP_Query( $args ); ?>

<div class="container archive-client">
	<div class="portfolio-wrapper clearfix">
		<div class="portfolio no-padd col-3 simple clearfix" data-space="10">
			<div class="wpb_column vc_column_container vc_col-sm-12  margin-lg-50b margin-xs-10b">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<?php while ( $portfolioCategory->have_posts() ) : $portfolioCategory->the_post();
							setup_postdata( $portfolioCategory ); ?>
							<div class="item block_item_0">
								<a href="<?php the_permalink(); ?>" class="item-link gridrotate-alb <?php echo esc_attr($hover); ?>" target="_self">
									<div class="item-img">
										<div class="images-one">
											<?php if (!get_post_thumbnail_id($post->ID)) {
												$portfolio_meta = get_post_meta($post->ID, 'whizz_portfolio_options');
												$images = explode(',', $portfolio_meta[0]['slider']);
												$url = (!empty($images[0]) && is_numeric($images[0])) ? wp_get_attachment_image_src($images[0], 'large') : ''; ?>
												<img src="<?php echo esc_url($url[0]); ?>" alt="" class="s-img-switch">
												<?php
											} else {
												$image_id = get_post_thumbnail_id($post->ID);
												$image = (is_numeric($image_id) && !empty($image_id)) ?wp_get_attachment_image_src($image_id, 'large') : ''; ?>
												<img src="<?php echo esc_url($image[0]); ?>" alt="" class="s-img-switch">
											<?php } ?>
										</div>
									</div>
									<div class="item-overlay">
										<?php the_title('<h5 class="portfolio-title">','</h5>'); ?></h5>
									</div>
								</a>
							</div>

						<?php endwhile;
						wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
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

get_footer(); ?>
