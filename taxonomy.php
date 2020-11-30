<?php get_header(); ?>
<div class="container">
  <h1 class="category-title">
    <?php echo single_cat_title() ?>
  </h1>
  <div class="post-list-wrapper">
    <div class="post-list">
      <?php while ( have_posts() ){ the_post(); ?>
        <div class="post-card">
          <div class="post-card-text">
          <a href="<?php the_permalink(); ?>">
            <h2 class="post-card-title"><?php echo mb_strimwidth(get_the_title(), 0, 45, " ..."); ?></h2>
          </a>
            <div class="post-card-info">
              <div class="author">
                <?php $author_id = get_the_author_meta('ID'); ?>
                <img src="<?php echo get_avatar_url($author_id) ?>" alt="" class="author-avatar">
                <div class="author-info">
                  <span class="author-name"><strong><?php the_author(); ?></strong></span>
                  <span class="date"><?php the_time( 'j F' ); ?></span>
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