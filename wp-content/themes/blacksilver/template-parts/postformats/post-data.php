<div class="postsummarywrap fullpage-item">
<?php
$postformat      = blacksilver_get_postformat();
$postformat_icon = blacksilver_get_postformat_icon( $postformat );
?>
	<div class="datecomment clearfix">
	<?php
	if ( is_single() ) {
		the_tags( '<div class="post-single-tags"><i class="feather-icon-tag"></i>', ' ', '</div>' );
	}
	?>
		<div class="post-single-meta-group-one">
			<span class="post-single-meta post-single-meta-author">
			<i class="<?php echo esc_attr( $postformat_icon ); ?>"></i>
			<span class="post-meta-author">
				<?php
				echo esc_html__( 'By ', 'blacksilver' );
				the_author();
				?>
			</span>
			</span>
			<span class="post-single-meta post-single-meta-date">
				<span class="post-meta-time">
				<i class="feather-icon-clock"></i>
				<?php
					echo '<span class="date updated">';
					echo get_the_date();
					echo '</span>';
				?>
				</span>
			</span>
		</div>
		<div class="post-single-meta-group-two">
			<span class="post-single-meta post-meta-category post-single-meta-category">
				<i class="<?php echo esc_attr( $postformat_icon ); ?>"></i>
				<?php
				the_category( ' / ' );
				?>
			</span>
			<?php
			$num_comments = get_comments_number();
			if ( comments_open() || $num_comments > 0 ) {
				?>
				<span class="post-single-meta post-single-meta-comment">
					<span class="post-meta-comment">
					<i class="feather-icon-speech-bubble"></i>
					<?php
					comments_popup_link( '0', '1', '%' );
					?>
					</span>
				</span>
				<?php
			}
			?>
		</div>
	</div>
</div>
