<?php
/**
 * Single Event
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

$events_meta = get_post_meta(get_the_ID(), 'whizz_events_options', true);
$events_meta_side = get_post_meta(get_the_ID(), 'whizz_events_options_side', true);
$event_style = $events_meta['event_style'];

if(!empty($events_meta_side['event_end_date'])){
	$real_time = date("F j, Y, H:i");
	$end_date = $events_meta_side['event_end_date'];
	$time_zone = get_option('gmt_offset');

	$unix_real_time = strtotime($real_time - $time_zone);
	$unix_end_date  = strtotime($end_date);
}

$images = !empty($events_meta['slider']) ? explode(',', $events_meta['slider']) : '';

$video_link = !empty($events_meta['video_url']) ? $events_meta['video_url'] : '';
if($event_style == 'video'){
	$video_params = array(
		'enablejsapi' => 1,
		'autoplay' => 1,
		'loop' => 1,
		'controls' => 0 ,
		'showinfo' => 0 ,
		'modestbranding' => 0,
		'rel' => 0,
	);
}


$event_end_text = cs_get_option('event_end_text') ? cs_get_option('event_end_text') : esc_html__('Event Cancelled', 'whizz');
$event_postponed_text = cs_get_option('event_postponed_text') ? cs_get_option('event_postponed_text') : esc_html__('Event Postponed', 'whizz');

$wrapClass = '';

if(!empty($events_meta_side['event_end_date'])){
	if ( $unix_end_date < $unix_real_time ) {
		$wrapClass .= 'canceled ';
	}
}

if(!empty($events_meta_side['event_postponed']) ){
    if( empty($events_meta_side['event_end_date']) || $unix_end_date > $unix_real_time){
	    $wrapClass .= 'canceled ';
    }
}

if($event_style == 'video'){
	$wrapClass .= 'iframe-video youtube play';
}

while (have_posts()) : the_post(); ?>

    <div class="post-details events-single-content">

        <div class="post-banner <?php echo esc_attr($wrapClass); ?>" data-type-start="click">

           <?php if ($event_style == 'gallery' && !empty($images)) {
                if (!empty($images) && count($images) >= 2 ) {
                        $images = array_slice($images, 0, 9); ?>

                    <div class="swiper-container" data-autoplay="5000" data-loop="1" data-speed="1000" data-slides-per-view="responsive" data-add-slides="1" data-xs-slides="1" data-sm-slides="1" data-md-slides="1" data-lg-slides="1">
                        <div class="swiper-wrapper">
                    <?php foreach ($images as $image) {
                            $url = (!empty($image) && is_numeric($image)) ? wp_get_attachment_image_src($image, 'full') : '';
                            $alt = get_post_meta($image, '_wp_attachment_image_alt', true); ?>
                            <div class="swiper-slide post-banner">
                                <?php echo whizz_the_lazy_load_flter($url[0], array(
                                    'class' => 's-img-switch',
                                    'alt' => $alt
                                )); ?>
                            </div>
                        <?php } ?>
                        </div>
                        <div class="pagination"></div>
                    </div>
                    <?php } else{
                        $image = get_post_thumbnail_id(get_the_ID()) ? get_post_thumbnail_id(get_the_ID()) : $images[0];
                        $image_url = (!empty($image) && is_numeric($image)) ? wp_get_attachment_image_src($image, 'full') : '';
                        if (!empty($image)) {
                            $alt = get_post_meta($image, '_wp_attachment_image_alt', true); ?>
                            <div class="images-one">
                                <?php
                                echo whizz_the_lazy_load_flter($image_url[0], array(
                                    'class' => 's-img-switch',
                                    'alt' => $alt
                                ));
                                ?>
                            </div>
                            <?php
                        }
                     }
	                } elseif($event_style == 'image' && has_post_thumbnail() ) {
	                    the_post_thumbnail( 'full', array( 'class' => 's-img-switch' ));
                    }elseif($event_style == 'video' && !empty($video_link)){

                        echo str_replace("?feature=oembed", "?feature=oembed&" . http_build_query ( $video_params ), wp_oembed_get($video_link));

	                    the_post_thumbnail( 'full', array( 'class' => 's-img-switch' )); ?>
                        <span class="video-close-button fa fa-close"></span>

                   <?php } ?>

            <div class="main-top-content text-center">
				<?php the_title( '<h2 class="title">', '</h2>' );
                if($event_style == 'video'){ ?>
                    <div class="video-content">
                        <a href="#" class="play-button start"></a>
                    </div>
                <?php } ?>
            </div>
	        <?php if(!empty($events_meta_side['event_end_date'])){
		        if ( $unix_end_date < $unix_real_time ) { ?>
                    <div class="end-event">
				        <?php echo esc_html($event_end_text); ?>
                    </div>
		        <?php }
	        }

	        if(!empty($events_meta_side['event_postponed']) && ( empty($events_meta_side['event_end_date']) || $unix_end_date > $unix_real_time) ){ ?>
                <div class="end-event">
			        <?php echo esc_html($event_postponed_text); ?>
                </div>
            <?php }?>
        </div>
    </div>

    <div class="container events-single-content <?php echo esc_attr($protected); ?>">

        <?php if(!post_password_required($post)){?>
            <div class="row">
                <div class="col-xs-12">
                        <div class="info-event-wrap">
	                        <?php if(!empty($events_meta_side['event_start_date']) && !empty($events_meta_side['event_end_date'])){ ?>
                            <div class="info-item">
                                <h5 class="title"><i class="fa "></i><?php esc_html_e('When', 'whizz'); ?></h5>
                                <div class="info">

	                                <?php if(!empty($events_meta_side['event_start_date'])){ ?>
                                        <div class="start-date">
			                                <?php

			                                $locale = get_locale() . ".utf8";
			                                $format = get_option( 'date_format' ) . ' ' . get_option('time_format');

			                                $startTime = $events_meta_side['event_start_date']; //american format
			                                if ( false === strtotime( $startTime ) ) { // in user set other locate (europe)
				                                $startTime = str_replace( '/', '-', $startTime );
			                                }

			                                echo esc_html(date($format, strtotime( $startTime ))); ?>
                                        </div>
	                                <?php }
	                                if(!empty($events_meta_side['event_end_date'])){ ?>
                                        <div class="end-date">
			                                <?php

			                                $locale = get_locale() . ".utf8";
			                                $format = get_option( 'date_format' ) . ' ' . get_option('time_format');

			                                $endTime = $events_meta_side['event_end_date']; //american format
			                                if ( false === strtotime( $endTime ) ) { // in user set other locate (europe)
				                                $endTime = str_replace( '/', '-', $endTime );
			                                }

			                                echo esc_html(date($format, strtotime( $endTime ))); ?>
                                        </div>
	                                <?php } ?>
                                </div>
                            </div>
	                        <?php } ?>
                            <?php if(!empty($events_meta_side['event_where'])){ ?>
                                <div class="info-item">
                                    <h5 class="title"><i class="fa "></i><?php esc_html_e('Where', 'whizz'); ?></h5>
                                    <div class="info">
                                        <?php echo do_shortcode($events_meta_side['event_where']); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if(!empty($events_meta_side['event_cost'])){ ?>
                                <div class="info-item">
                                    <h5 class="title"><i class="fa "></i><?php esc_html_e('Cost', 'whizz'); ?></h5>
                                    <div class="info">
                                        <?php echo esc_html($events_meta_side['event_cost']); ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <div class="content-main">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        <?php }
        if (post_password_required($post)) { ?>
            <h3 class="protected-title"><?php echo esc_html(cs_get_option('events_protect_title')); ?></h3>
            <?php the_content();
        }
        if ($events_meta['whizz_navigation_events']) { ?>
            <div class="row">
                <div class="single-pagination margin-lg-10b">
                    <?php
                    $prev_post = get_previous_post();
                    if (!empty($prev_post)) :
                        ?>
                        <div class="pag-prev">
                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="content">
                                <?php esc_html_e('Previous event', 'whizz'); ?>
                            </a>
                        </div>
                    <?php endif;
                    $next_post = get_next_post();
                    if (!empty($next_post)) :
                        ?>
                        <div class="pag-next">
                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="content">
                                <?php esc_html_e('Next event', 'whizz'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php } ?>
    </div>

	<?php
        $username = cs_get_option('insta_username');
        $count    = cs_get_option('insta_count') ? cs_get_option('insta_count') : '21';

    if(!empty($username) && cs_get_option('instagram_events')){ ?>
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
    <?php
endwhile;
get_footer();