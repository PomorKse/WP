<?php get_header(); ?>
<div class="container">
  <h1 class="search-title">Результаты поиска по запросу:</h1>
  <div class="search-wrapper">
    <div class="search-pagination">
      <ul class="article-list-2">
        <?php if ( have_posts() ){ while ( have_posts() ){ the_post(); ?>
          <li class="article-list-2-item">
            <a href="<?php the_permalink(); ?>" class="article-list-2-permalink">
              <img src="<?php if( has_post_thumbnail() ) {
                echo get_the_post_thumbnail_url(); 
              }
              else {
                echo get_template_directory_uri() . '/assets/img/img-default.png';
              } ?>" alt="" class="article-list-2-thumb">
            </a>
            <div class="article-list-2-item-wrapper">
              <span>
                <?php 
                  foreach (get_the_category() as $category) {
                    printf(
                      "<a href='%s' class='category-link %s'>%s</a>",
                      esc_url( get_category_link($category) ),
                      esc_html( $category -> slug ),
                      esc_html( $category -> name )
                    );
                  }
                  ?>
              </span>
              <a href="<?php the_permalink(); ?>" class="article-list-2-permalink">
                <h4 class="article-list-2-title"><?php echo mb_strimwidth(get_the_title(), 0, 65, " ..."); ?></h4>
              </a>
              <p class="article-list-2-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 160, " ..."); ?></p>
              <div class="article-list-2-item-info">
                <span class="date"><?php the_time( 'j F' ); ?></span>
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
              </div><!-- end .article-grid-info -->
            </div>
            <!-- end .article-list-2-item-wrapper -->
          </li>
        <?php } } else { ?>
          Записей нет.
        <?php } ?>
      </ul>
      <?php the_posts_pagination() ?>
    </div><!-- end .search-pagination -->

    <!-- Подключаем сайдбар -->
    <?php get_sidebar('home-bottom'); ?>

  </div><!-- end .search-wrapper -->
</div><!-- end .container -->
<?php get_footer(); ?>