<?php
$post_nav_class = ' post-nav-has-no-prev-next';
$prev_post      = get_previous_post();
$next_post      = get_next_post();
if ( empty( $prev_post ) ) {
	$post_nav_class = ' post-nav-has-no-prev';
}
if ( empty( $next_post ) ) {
	$post_nav_class = ' post-nav-has-no-next';
}
?>
<div class="post-thumbnail-navigation<?php echo esc_attr( $post_nav_class ); ?>">
<?php
if ( ! empty( $prev_post ) ) :
	?>
		<div class="post-thumbnail-navigation-outer post-thumbnail-navigation-outer-left">
			<div class="post-nav-thumbnail post-nav-thumbnail-left">
				<?php echo get_the_post_thumbnail( $prev_post->ID, 'thumbnail' ); ?>
			</div>
			<div class="post-thumbnail-navigation-inner post-thumbnail-navigation-inner-left">
				<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					<div class="post-thumbnail-nav post-thumbnail-nav-prev">
						<span class="post-thumbnail-desc">
							<?php
							esc_html_e( 'Prev', 'blacksilver' );
							?>
						</span>
						<span class="post-thumbnail-nav-link">
						<?php
						echo esc_html( $prev_post->post_title );
						?>
						</span>
					</div>
				</a>
			</div>
		</div>
	<?php
endif;
if ( ! empty( $next_post ) ) :
	?>
		<div class="post-thumbnail-navigation-outer post-thumbnail-navigation-outer-right">
			<div class="post-thumbnail-navigation-inner post-thumbnail-navigation-right">
				<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<div class="post-thumbnail-nav post-thumbnail-nav-next">
						<span class="post-thumbnail-desc">
							<?php
							esc_html_e( 'Next', 'blacksilver' );
							?>
						</span>
						<span class="post-thumbnail-nav-link">
						<?php
						echo esc_html( $next_post->post_title );
						?>
						</span>
					</div>
				</a>
			</div>
			<div class="post-nav-thumbnail post-nav-thumbnail-right">
				<?php echo get_the_post_thumbnail( $next_post->ID, 'thumbnail' ); ?>
			</div>
		</div>
	<?php
endif;
?>
</div>
