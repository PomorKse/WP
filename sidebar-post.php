<?php
if ( ! is_active_sidebar( 'post-sidebar' ) ) {
	return;
}
?>

<aside class="sidebar-post-page">
	<?php dynamic_sidebar( 'post-sidebar' ); ?>
</aside><!-- #secondary -->

