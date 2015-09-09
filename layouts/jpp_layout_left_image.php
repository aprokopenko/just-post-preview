<?php

/* @var $instance array */
/* @var $post WP_Post */

?>
<article id="jpp-entry-<?php echo $post->ID; ?>" class="jpp_entry">
	<?php if( has_post_thumbnail($post->ID) ) : ?>
		<div class="post-image jpp-align-image-left"><?php echo get_the_post_thumbnail($post->ID, 'large'); ?></div>
	<?php endif; ?>
	<header class="entry-header">
		<h2 class="entry-title"><?php echo get_the_title($post); ?></h2>
	</header>
	<div class="jpp_entry_content">
		<?php echo jpp_trim_excerpt($post); ?>
	</div>
	<div class="jpp_meta">
		<a href="<?php echo get_permalink($post->ID); ?>" class="jpp_readmore">Read more</a>
	</div>
</article>