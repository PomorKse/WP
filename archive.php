<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package universal-example
 */
get_header(); ?>

<div class="container">
	<?php if ( function_exists( 'universal_breadcrumbs' ) ) universal_breadcrumbs(); ?>

  <h1 class="category-title">
    <?php wp_title('') ?>
  </h1>
  <div class="post-list-wrapper">
    <div class="post-list">
      <?php while ( have_posts() ){ the_post(); ?>
        <div class="post-card">
          <a href="<?php the_permalink(); ?>">
            <img src="<?php if( has_post_thumbnail() ) {
                              echo get_the_post_thumbnail_url(); 
                            }
                            else {
                              echo get_template_directory_uri() . '/assets/img/img-default.png';
                            }
                      ?>" alt="" class="post-card-thumb">
          </a>
          <div class="post-card-text">
          <a href="<?php the_permalink(); ?>">
            <h2 class="post-card-title"><?php echo mb_strimwidth(get_the_title(), 0, 45, " ..."); ?></h2>
          </a>
            <p class="post-card-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 90, " ..."); ?></p>
            <div class="post-card-info">
              <div class="author">
                <?php $author_id = get_the_author_meta('ID'); ?>
                <img src="<?php echo get_avatar_url($author_id) ?>" alt="" class="author-avatar">
                <div class="author-info">
                  <span class="author-name"><strong><?php the_author(); ?></strong></span>
                  <span class="date"><a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>"><?php the_time( 'j F' ); ?></a></span>
                  <div class="comments">
                    <svg class="icon comments-icon">
                      <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#comment"></use>
                    </svg>
                    <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                  </div>
                  <div class="likes">
                    <svg class="icon likes-icon">
                      <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#likes"></use>
                    </svg>
                    <span class="likes-counter"><?php comments_number('0', '1', '%'); ?></span>
                  </div>
                </div><!-- end .author-info -->
              </div>
              <!-- end .author -->
            </div><!-- end .post-card-info -->
          </div><!-- end .post-card-text -->


        </div><!-- end .card -->
      <?php } ?>
      <?php if ( ! have_posts() ){ ?>
        Записей нет.
      <?php } ?>
    </div><!-- end .post-list -->
    <?php the_posts_pagination() ?>
  </div><!-- end .post-list-wrapper -->
</div><!-- end .container -->

<?php get_footer(); ?>

