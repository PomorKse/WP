<?php get_header(); ?>
<div class="container">
  <?php if ( function_exists( 'universal_breadcrumbs' ) ) universal_breadcrumbs(); ?>
  <h1 class="taxonomy-title">
    <?php echo single_cat_title() ?>
  </h1>
  <div class="lesson-list-wrapper">
    <div class="lesson-list">
      <?php while ( have_posts() ){ the_post(); ?>
        <div class="lesson-card">
          <a href="<?php the_permalink(); ?>">
            <h2 class="lesson-card-title"><?php the_title(); ?></h2>
          </a>
          <div class="lesson-video">
            <?php 
            $tmp = get_field('video_link');
            if (stristr($tmp, 'youtube')) {
              $url = explode('?v=', $tmp); ?>
              <iframe width="60%" height="430" src="https://www.youtube.com/embed/<?php echo end($url); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php 
            } elseif (stristr($tmp, 'vimeo')) {
              $url = explode('/', $tmp); ?>
              <iframe src="https://player.vimeo.com/video/<?php echo end($url); ?>" width="60%" height="430" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            <?php
            } ?>
          </div>

           <div class="lesson-card-info">
            <?php $author_id = get_the_author_meta('ID'); ?>
            <img src="<?php echo get_avatar_url($author_id) ?>" alt="" class="author-avatar">
            <div class="author-info">
              <span class="author-name"><strong><?php the_author(); ?></strong></span>
              <div class="lesson-card-date">
                <svg class="icon clock-icon">
                  <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#clock"></use>
                </svg>
                <span class="date"><?php the_time( 'j F, H:i' ); ?></span>
              </div><!-- end .lesson-card-date -->
            </div><!-- end .author-info -->
          </div><!-- end .lesson-card-info -->
        </div><!-- end .lesson-card -->
      <?php } ?>
      <?php if ( ! have_posts() ){ ?>
        Записей нет.
      <?php } ?>
    </div><!-- end .lesson-list -->
    <?php the_posts_pagination() ?>
  </div><!-- end .lesson-list-wrapper -->

</div><!-- end .container -->

<?php get_footer(); ?>