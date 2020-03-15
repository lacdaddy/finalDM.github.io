<?php
/**
 * Requried functions for theme backend.
 *
 * @package whizz
 * @subpackage Template
 */

// cs framework missing
if ( ! function_exists( 'cs_get_option' ) ) {
	function cs_get_option() {
		return '';
	}

	function cs_get_customize_option() {
		return '';
	}
}

if ( ! function_exists( 'whizz_add_default_cs_websafe_fonts' )) {
	function whizz_add_default_cs_websafe_fonts($params)
	{
		return array_merge(array(''),$params);
	}
}
add_filter( 'cs_websafe_fonts', 'whizz_add_default_cs_websafe_fonts' );

/**
 * Сustom whizz menu.
 */
if ( ! function_exists( 'whizz_custom_menu' ) ) {
	function whizz_custom_menu() {

		$walker = new whizz_Menu_Walker();
		$args = array( 'container' => '', 'walker' => $walker );
		$meta_data = get_post_meta( get_the_ID(), '_custom_page_options', true );

		if ( isset( $meta_data['page_menu'] ) && $meta_data['page_menu'] !== 'none' ) {
			$args['menu'] = $meta_data['page_menu'];
			wp_nav_menu( $args );
		} else {
			if ( has_nav_menu( 'primary-menu' ) ) {
				$args['theme_location'] = 'primary-menu';
				wp_nav_menu( $args );
			} else {
				echo '<span class="no-menu">' . esc_html__( 'Please register Top Navigation from', 'whizz' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance &gt; Menus', 'whizz' ) . '</a></span>';
			}
		}

	}
}

/**
 * Сustom whizz menu list.
 */
if ( ! function_exists( 'whizz_get_menus' ) ) {
	function whizz_get_menus() {
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		$array = array( 'none' => 'None' );
		foreach ( $menus as $menu ) {
			$array[ $menu->slug ] = $menu->name;
		}

		return $array;
	}
}


/**
 *
 * Get first "url" from post content or string
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'whizz_get_first_url_from_string' ) ) {
	function whizz_get_first_url_from_string( $string ) {
		$pattern = "/^\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		preg_match( $pattern, $string, $link );

		return ( ! empty( $link[0] ) ) ? $link[0] : false;
	}
}

/**
 *
 * Custom Regular Expression
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'whizz_get_shortcode_regex' ) ) {
	function whizz_get_shortcode_regex( $tagregexp = '' ) {
		// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
		// Also, see shortcode_unautop() and shortcode.js.
		return
			'\\['                                // Opening bracket
			. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
			. "($tagregexp)"                     // 2: Shortcode name
			. '(?![\\w-])'                       // Not followed by word character or hyphen
			. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
			. '[^\\]\\/]*'                   // Not a closing bracket or forward slash
			. '(?:'
			. '\\/(?!\\])'               // A forward slash not followed by a closing bracket
			. '[^\\]\\/]*'               // Not a closing bracket or forward slash
			. ')*?'
			. ')'
			. '(?:'
			. '(\\/)'                        // 4: Self closing tag ...
			. '\\]'                          // ... and closing bracket
			. '|'
			. '\\]'                          // Closing bracket
			. '(?:'
			. '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
			. '[^\\[]*+'             // Not an opening bracket
			. '(?:'
			. '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
			. '[^\\[]*+'         // Not an opening bracket
			. ')*+'
			. ')'
			. '\\[\\/\\2\\]'             // Closing shortcode tag
			. ')?'
			. ')'
			. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
	}
}

/**
 *
 * Tag Regular Expression
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'whizz_tagregexp' ) ) {
	function whizz_tagregexp() {
		return apply_filters( 'whizz_custom_tagregexp', 'video|audio|playlist|video-playlist|embed|cs_media' );
	}
}

/**
 *
 * POST FORMAT: VIDEO & AUDIO
 *
 */
if ( ! function_exists( 'whizz_post_media' ) ) {
	function whizz_post_media( $content ) {
		$result = strpos( $content, 'iframe' );
		if ( $result === false ) {
			$media = whizz_get_first_url_from_string( $content );
			if ( ! empty( $media ) ) {
				global $wp_embed;
				$content = do_shortcode( $wp_embed->run_shortcode( '[embed]' . $media . '[/embed]' ) );
			} else {
				$pattern = whizz_get_shortcode_regex( whizz_tagregexp() );
				preg_match( '/' . $pattern . '/s', $content, $media );
				if ( ! empty( $media[2] ) ) {
					if ( $media[2] == 'embed' ) {
						global $wp_embed;
						$content = do_shortcode( $wp_embed->run_shortcode( $media[0] ) );
					} else {
						$content = do_shortcode( $media[0] );
					}
				}
			}
			if ( ! empty( $media ) ) {
				$output = $content;

				return $output;
			}

			return false;
		} else {
			return $content;
		}
	}
}

/**
 *
 * Create custom html structure for comments
 *
 */
if ( ! function_exists( 'whizz_comment' ) ) {
	function whizz_comment( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ):
			case 'pingback':
			case 'trackback': ?>
				<p>
					<?php esc_html_e( 'Pingback:', 'whizz' ); ?><?php comment_author_link(); ?>
					<?php edit_comment_link( esc_html__( '(Edit)', 'whizz' ), '<span class="edit-link">', '</span>' ); ?>
				</p>
				<?php
				break;
			default:
				// generate comments
				?>
				<li <?php comment_class( 'ct-part' ); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
					<div class="content">
						<div class="person">
							<?php echo get_avatar( $comment, '70', '', '', array( 'class' => 'img-person' ) ); ?>
							<a href="#" class="author">
								<?php comment_author(); ?>
							</a>
                          <span class="comment-date">
                            <?php comment_date( get_option( 'date_format' ) ); ?>
                          </span>
						</div>
						<?php
						comment_reply_link(
							array_merge( $args,
								array(
									'reply_text' => esc_html__( 'Reply', 'whizz' ),
									'after'      => '',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth']
								)
							)
						);
						?>
						<div class="text">
							<?php comment_text(); ?>
						</div>
					</div>
				</div>
				<?php
				break;
		endswitch;
	}
}

/*
 * Site logo function.
 */
if ( ! function_exists( 'whizz_site_logo' ) ) {
	function whizz_site_logo() {
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">

			<?php

			if(is_404() && cs_get_option('error_logo')){
				if ( apply_filters( 'whizz_type_logo', cs_get_option( 'error_site_logo' )) == 'txtlogo'  ) {
					echo ' <span> ' . esc_html( cs_get_option( 'error_text_logo' ) ) . '</span>';
				} else {
					$logo = '';
					if (cs_get_option( 'error_image_logo' )) {
						$logo = cs_get_option('error_image_logo');
					}

					// logo for page
					?>
					<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo get_option( 'blogname' ); ?>">

				<?php }
			} else {
				$meta_data = get_post_meta( get_the_ID(), '_custom_page_options', true );

				if ( apply_filters( 'whizz_type_logo', cs_get_option( 'site_logo' ) ) == 'imglogo'  ) {

					$logo = '';
					if ( cs_get_option( 'menu_style' ) == 'right' ) {
						$logo = cs_get_option( 'image_logo' );
					} elseif ( cs_get_option( 'menu_style' ) == 'center' ) {
						$logo = cs_get_option( 'image_logo2' );
					}elseif ( cs_get_option( 'menu_style' ) == 'aside' ) {
						$logo = cs_get_option( 'image_logo3' );
                    }elseif(cs_get_option( 'menu_style' ) == 'static_aside' ){
						$logo = cs_get_option( 'image_logo4' );
                    }elseif(cs_get_option( 'menu_style' ) == 'left' ){
						$logo = cs_get_option( 'image_logo5' );
                    }elseif(cs_get_option( 'menu_style' ) == 'compact' ){
						$logo = cs_get_option( 'image_logo6' );
                    }elseif(cs_get_option( 'menu_style' ) == 'full' ){
						$logo = cs_get_option( 'image_logo7' );
					}

					// logo for page

					$logo = ! empty( $meta_data['image_page_logo'] ) ? $meta_data['image_page_logo'] : $logo;

					$image_logo = apply_filters( 'whizz_header_logo', $logo );
					$img_src = ! empty( $image_logo ) ? $image_logo : WHIZZ_T_URI . '/assets/images/logo.png'; ?>
                    <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo get_option( 'blogname' ); ?>">

					<?php

				} elseif ( ! function_exists( 'cs_framework_init' ) ) {
					echo '<span>' . get_option( 'blogname' ) . '</span>';
                } else {
					echo '<span>' . esc_html( cs_get_option( 'text_logo' ) ) . '</span>';
                }
			} ?>
		</a>
	<?php }
}

/*
 * Blog item header.
 */
if ( ! function_exists( 'whizz_blog_item_hedeader' ) ) {
	function whizz_blog_item_hedeader( $option, $post_id , $video_params = array(), $classButton = '', $classWrap = '' ) {
		$format = get_post_format( $post_id );
		if ( isset( $option[0]['post_preview_style'] ) ) {
			switch ( $option[0]['post_preview_style'] ) {
				case 'image':
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
					if ( empty( $image ) && ( $format != 'quote' ) ) {
						$image[0] = cs_get_option( 'default_post_image' );
					}
					$output = '<div class="post-media">';
					$output .= whizz_the_lazy_load_flter( $image[0], array(
						'class' => 's-img-switch',
						'alt'   => ''
					) ); 
					$output .= '</div>';
					break;
				case 'video':
					$output = '<div class="post-media video-container iframe-video youtube ' . esc_attr($classWrap) . '" data-type-start="click">';
                    $video_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
                    $output .= whizz_the_lazy_load_flter( $video_img[0], array(
                        'class' => 's-img-switch',
                        'alt'   => ''
                    ) );
                    $video_params = empty($video_params) ? array(
                        'enablejsapi' => 1,
                        'loop' => 1,
                        'controls' => 0 ,
                        'showinfo' => 0 ,
                        'modestbranding' => 0,
                        'rel' => 0,
                    ) : $video_params;

                    $services = $option[0]['post_preview_video_type'];
                    $video_link = $option[0]['post_preview_video'];

                    if (empty($services) ||  $services == 'youtube' || $services == 'vimeo') {
                        if (!empty($video_link) && $services == 'youtube') {
                            $output .= str_replace("?feature=oembed", "?feature=oembed&" . http_build_query ( $video_params ), wp_oembed_get($video_link));
                        }
                        if ($services == 'vimeo') {
                            $video_iframe = wp_oembed_get($video_link);
                            $video_iframe = str_replace("src=\"", "src=\"about:blank\" data-src=\"", $video_iframe );
                            $output .= preg_replace("/\/(\d+?)\"/","/$1?" . http_build_query ( $video_params ) . "\"", $video_iframe );
                        }
                    }

                    $output .= '<div class="video-content"><a href="#" class="play-button ' . esc_attr($classButton) . '"></a></div>';
					$output .= '<span class="video-close-button fa fa-close"></span>';
					$output .= '</div>';
					break;
				case 'slider':
					$output = '<div class="post-media">';
					$output .= '<div class="img-slider">';
					$output .= '<ul class="slides">';
					$images = explode( ',', $option[0]['post_preview_slider'] );
					foreach ( $images as $image ) {
						$url = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';
						if ( ! empty( $url ) ) {
							$output .= '<li class="post-slider-img">';
							$output .= whizz_the_lazy_load_flter( $url, array(
								'class' => 's-img-switch',
								'alt'   => ''
							) ); 
							$output .= '</li>';
						}
					}
					$output .= '</ul>';
					$output .= '</div>';
					$output .= '</div>';
					break;
				case 'text':
					$output = '<i class="fa fa-quote-right fa-2x"></i><blockquote>';
					$output .= wp_kses_post( $option[0]['post_preview_text'] );
					$output .= '</blockquote>';
					break;
				case 'audio':
					$output = '<div class="post-media">';
					$output .=  whizz_post_media( $option[0]['post_preview_audio'] );
					$output .= '</div>';
					break;
			}

			if ( $format == 'quote' ) {
				$post_preview_text = $option[0]['post_preview_text'] ? $option[0]['post_preview_text'] : get_the_excerpt();
				$output            = '<i class="fa fa-quote-right fa-2x"></i><blockquote>';
				$output .= wp_kses_post( $post_preview_text );
				$output .= '</blockquote>';
			}

		} else {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
			if ( empty( $image ) ) {
				$image[0] = cs_get_option( 'default_post_image' );
			}
			$output = '<div class="post-media">';
			$output .= whizz_the_lazy_load_flter( $image[0], array(
				'class' => 's-img-switch',
				'alt'   => ''
			) );  
			$output .= '</div>';
		}
		echo do_shortcode($output);
	}
}

/*
* Get Page For Navi
*/
if ( ! function_exists( 'whizz_get_pages_for_navi' ) ) {
	function whizz_get_pages_for_navi() {
		$posts = get_posts( "post_type=page&post_status=publish&numberposts=99999&orderby=menu_order" );
		$pages = get_page_hierarchy( $posts );
		$pages = array_keys( $pages );

		return $pages;
	}
}


/**
 *
 * Get instagram images.
 * @since 1.0.0
 * @version 1.0.0
 *
 **/
if ( ! function_exists( 'whizz_get_imstagram' ) ) {
    function whizz_get_imstagram( $username, $count_photos = 7 ) {
		// TODO (don't know why we use this variable)
		$insta_token_switcher = cs_get_option('insta_token_switcher');

		$access_token_instagram = cs_get_option('access_token_instagram');
		
        if ( $insta_token_switcher && ! empty( $access_token_instagram ) ) {
			$response = wp_remote_get( sprintf( 'https://api.instagram.com/v1/users/self/media/recent/?access_token=%s&count=%s', $access_token_instagram, $count_photos ) );

            if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
                return false;
            }
            $data = json_decode( wp_remote_retrieve_body( $response ) );
            $result = array();
            $username = '';
            foreach ( $data->data as $item ) {

                if ( empty( $username ) ) {
                    $username = $item->user->username; 
                }

                $crop_function = false;
                $thumbnail     = $item->images->thumbnail->url;
                preg_match( "/\/([c]\d{1,4}\.\d{1,4}\.\d{1,4}\.\d{1,4})\//", $thumbnail, $crop_function );

                $result[] = array(
                    'link'          => $item->link,
                    'large'     	=> $item->images->standard_resolution->url
                );
            }

            // $result = array('items' => $result, 'username'=>$username);

            return $result;
        } else {
            $error       = false;
            $media_array = '';
            // delete_transient( 'instagram-media-' . sanitize_title_with_dashes( $username ) );
            if ( false === ( $instagram = get_transient( 'instagram-media-' . sanitize_title_with_dashes( $username ) ) ) ) {
                $remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) );

                if ( is_wp_error( $remote ) ) {
                    $error = esc_html__( 'Unable to communicate with Instagram.', 'whizz' );
                }
                if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
                    $error = esc_html__( 'Instagram error.', 'whizz' );
                }
                $shared      = explode( 'window._sharedData = ', $remote['body'] );
                $insta_json  = explode( ';</script>', $shared[1] );
                $insta_array = json_decode( $insta_json[0], true );
                if ( ! $insta_array ) {
                    $error = esc_html__( 'Instagram has returned invalid data.', 'whizz' );
                }
                if ( ! $error ) {
                    $images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
                    $instagram = array();

                    foreach ( $images as $image ) {
                        $instagram[] = array(
                            'link'  => $image['node']['shortcode'],
                            'large' => $image['node']['display_url'],
                        );
                    }

                    $instagram = serialize( $instagram );
                    set_transient( 'instagram-media-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
                }
            }
            if ( $error ) {
                $output = $error;
            } else {
                $instagram    = unserialize( $instagram );
                $count_photos = ( ! empty( $count_photos ) && is_numeric( $count_photos ) ) ? $count_photos : 7;
                $media_array  = array_slice( $instagram, 0, $count_photos );
            }

            return $media_array;
        }

    }
}

// Custom row styles for onepage site type+-.
if ( ! function_exists('whizz_dynamic_css' ) ) {
  function whizz_dynamic_css() {
    require_once get_template_directory() . '/assets/css/custom.css.php';
    wp_die();
  }
}
add_action( 'wp_ajax_nopriv_whizz_dynamic_css', 'whizz_dynamic_css' );
add_action( 'wp_ajax_whizz_dynamic_css', 'whizz_dynamic_css' );

/*
* whizz Mini Cart for Woocommerce
*/
if (! function_exists('whizz_mini_cart' ) ) {
	function whizz_mini_cart(){

		if ( class_exists( 'WooCommerce' ) ){

			ob_start();
			?>
			<div class="whizz_mini_cart">

				<?php do_action( 'woocommerce_before_mini_cart' ); ?>

				<ul class="cart_list product_list_widget">

					<?php if ( ! WC()->cart->is_empty() ) : ?>

						<?php
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
								$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

								if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
									$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
									$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
									$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
									?>
									<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
										<div class="mini_cart_item_thumbnail">
											<?php if ( ! $_product->is_visible() ) : ?>
												<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
											<?php else : ?>
												<a href="<?php echo esc_url( $product_permalink ); ?>">
													<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
												</a>
											<?php endif; ?>
										</div>

										<div class="mini-cart-data">
											<a href="<?php echo esc_url( $product_permalink ); ?>" class="mini_cart_item_name">
												<?php echo wp_kses_post( $product_name ); ?>
											</a>

											<div class="mini_cart_item_quantity">
												<?php esc_html_e('x', 'whizz'); ?>
												<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . $cart_item['quantity'] . '</span>', $cart_item, $cart_item_key ); ?>
											</div>

											<div class="mini_cart_item_price">
												<?php if ( ! empty( $product_price ) ) {
													echo wp_kses_post( $product_price );
												} ?>
											</div>
										</div>
										
									</li>
									<?php
								}
							}
						?>

					<?php else : ?>

						<li class="empty"><?php esc_html_e( 'No products in the cart.', 'whizz' ); ?></li>

					<?php endif; ?>

				</ul><!-- end product list -->

				<?php if ( ! WC()->cart->is_empty() ) : ?>

					<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

					<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'whizz' ); ?></a>

				<?php endif; ?>

				<?php do_action( 'woocommerce_after_mini_cart' ); ?>

			</div>

			<?php 
			return ob_get_clean();
		}
	}
}

if (! function_exists('whizz_the_share_posts')) {
	function whizz_the_share_posts($post,$show_title = '')
	{	
		if ( cs_get_option( 'social_portfolio' ) ) { 
			ob_start();  ?>
				<div class="row single-share">
					<div class="ft-part margin-lg-15b">
						<ul class="social-list">
							<?php if (!empty($show_title)) { ?>
							<li><span><?php esc_html_e( 'Share:', 'whizz' ); ?></span></li>
							<?php } ?>
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
								   class="twitter" target="_blank" title="Tweet"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="http://plus.google.com/share?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
								   target="_blank" class="gplus"><i class="fa fa-google-plus"></i></a></li>
						</ul>
					</div>
				</div>
			<?php 
			echo ob_get_clean();
		}
	} 
}

if ( ! function_exists( 'whizz_get_post_shortcode_params' ) ) {
	function whizz_get_post_shortcode_params($tag_shortcode, $string = '', $all = false)
	{

		if (empty($tag_shortcode)) return false;

		if (empty($string)) {
			global $post;
			$string = $post->post_content;
		}
		
		preg_match_all( "/" . get_shortcode_regex(array($tag_shortcode)) . "/si" ,
					$string,
					$matchs );
		if (!empty($matchs[0])) {

			if ($all) {
				$params = array();
				foreach ($matchs[0] as $key => $param) {
					$this_param = str_replace('"]', '" ]', $matchs[$key][0]);
					$atts = shortcode_parse_atts($this_param);
					if (is_array($atts)) {
					$this_param = array_slice($atts, 1, -1);
						$params[] = $this_param;
					}
				}
				return $params;
			}

			$params = str_replace('"]', '" ]', $matchs[0][0]);
			$params = array_slice(shortcode_parse_atts($params), 1, -1);
			if (is_array($params)) {
				return $params;
			}
			return false;
		}
		return false;

	}
}

if (!function_exists('whizz_include_fonts')) {
	function whizz_include_fonts($fonts = '') {
		if ( empty($fonts) ) return ''; 

		if ( !is_array($fonts) ) {
			$fonts = array( $name_option );
		}

		foreach ($fonts as $key => $font) {
			if ( cs_get_option($font) ) { 

				$font_family = cs_get_option($font);
				if(! empty($font_family['family']) ) {
					wp_enqueue_style( sanitize_title_with_dashes($font_family['family']), '//fonts.googleapis.com/css?family=' . $font_family['family'] . ':' . $font_family['variant'] .'' );
				}
			}
		}

	}
}

// functions max word in string
if ( ! function_exists( 'whizz_maxsite_str_word' ) ) {
	function whizz_maxsite_str_word( $text, $counttext = 10, $sep = ' ' ) {
		$words = explode( $sep, $text );
		if ( count( $words ) > $counttext )
			$text = join( $sep, array_slice( $words, 0, $counttext ) );
		return $text;
	}
}


if ( ! function_exists( 'whizz_excerpt_more' ) ) {
	function whizz_excerpt_more() {
		return ' ...';
	}
	add_filter('excerpt_more', 'whizz_excerpt_more');
}

/**
 * Woocommerce variable script
 * return string
 */
if ( ! function_exists('whizz_variable_script') ) {
	function whizz_variable_script($name) { ?>
        <script>
            jQuery('input[name="attribute_<?php echo esc_attr( sanitize_title($name)); ?>_radio"]').click(function() {
                jQuery('#product-select-<?php echo esc_attr( sanitize_title($name) ); ?>').val(this.value);
                jQuery('#product-select-<?php echo esc_attr( sanitize_title($name) ); ?>').trigger('change');
            });
        </script>
	<?php }
	add_action('whizz_variable_script', 'whizz_variable_script');
}