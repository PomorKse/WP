<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!--шапка поста-->
  <header class="entry-header <?php echo get_post_type(); ?>-header" style="background-image: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
    <?php
      if( has_post_thumbnail() ) {
        echo get_the_post_thumbnail_url(); 
        }
        else {
          echo get_template_directory_uri() . '/assets/img/img-default.png';
        }
    ?>); background-size: cover; background-position: center">

    <div class="container">
        <div class="post-header-wrapper">
          <div class="post-header-nav">
            <?php
              //Выводим категорию
              foreach (get_the_category() as $category) {
                printf(
                  "<a href='%s' class='category-link %s'>%s</a>",
                  esc_url( get_category_link($category) ),
                  esc_html( $category -> slug ),
                  esc_html( $category -> name )
                );
              }
            ?>
            <a class="home-link" href="<?php echo get_home_url(); ?>">
              <svg class="icon home-icon">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#home"></use>
              </svg>
              На главную
            </a>
            <?php
            //Выводим ссылки на предыдущий и следущий посты
            the_post_navigation(
              array(
                'prev_text' => '<span class="post-nav-prev">
                <svg class="icon prev-icon">
                  <use xlink:href="' . get_template_directory_uri() . '/assets/img/sprite.svg#arrow"></use>
                </svg>' . esc_html__( 'Prev', 'universal' ) . '</span>',
                'next_text' => '<span class="post-nav-next">' . esc_html__( 'Next', 'universal' ) . 
                '<svg class="icon next-icon">
                  <use xlink:href="' . get_template_directory_uri() . '/assets/img/sprite.svg#arrow"></use>
                </svg></span>',
              )
            );
            ?>
          </div><!-- end .post-header-nav -->

          <div class="post-header-title-wrapper">
            <?php
              //Проверяем, точно ли мы на странице поста
              if ( is_singular() ) :
                the_title( '<h1 class="post-header-title">', '</h1>' );
              else :
                the_title( '<h2 class="post-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
              endif;
            ?>
            <button class="bookmark">
              <svg class="icon bookmark-icon">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#bookmark"></use>
              </svg>
            </button>
          </div>

          <p><?php echo mb_strimwidth(get_the_excerpt(), 0, 170, " ..."); ?></p>

          <div class="post-header-info">
            <svg class="icon clock-icon">
              <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#clock"></use>
            </svg>
            <span class="date"><a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>"><?php the_time( 'j F, H:i' ); ?></a></span>
            <div class="likes">
              <svg class="icon likes-icon">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#likes"></use>
              </svg>
              <span class="likes-counter"><?php comments_number('0', '1', '%'); ?></span>
            </div>
            <div class="comments">
              <svg class="icon comments-icon">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#comment"></use>
              </svg>
              <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
            </div>
          </div><!-- end .post-header-info -->

          <div class="post-author">
            <div class="post-author-info">
              <?php $author_id = get_the_author_meta('ID'); ?>
                  <img src="<?php echo get_avatar_url($author_id)?>" class="post-author-avatar" alt="">
                  <span class="post-author-name"><?php the_author(); ?></span>
                  <span class="post-author-rank">
                    <?php
                      //Получаем список всех ролей WP(глобальная переменная)
                      $roles = wp_roles()->roles;
                      //узнаем текущую роль пользователя
                      $current_role = get_the_author_meta( 'roles', $author_id )[0];
                      //перебираем все роли WP
                      foreach ($roles as $role => $value) {
                        //если наша текущая роль совпадает с ролью из списка
                        if ($role == $current_role) {
                          //выводим название роли
                          echo $value['name'];
                        }
                      }
                    ?>
                  </span>
                  <span class="post-author-posts">
                    <?php plural_form(count_user_posts($author_id),
                    //варианты написания для количества 1, 2 и 5
                      array('статья', 'статьи', 'статей')) ?>
                  </span>
            </div><!-- end .post-author-info -->
            <a href="<?php echo get_author_posts_url($author_id); ?>" class="post-author-link">
                Страница автора
            </a><!-- end .post-author-link -->
          </div><!-- end .post-author -->

        </div><!-- end .post-header-wrapper -->
    </div><!-- end .container -->
	</header><!-- end.entry-header -->

  <!-- Содержимое поста -->
  <div class="container">
    <div class="post-content">
      <?php
      //выводим содержимое
        the_content(
          sprintf(
            wp_kses(
              /* translators: %s: Name of current post. Only visible to screen readers */
              __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal' ),
              array(
                'span' => array(
                  'class' => array(),
                ),
              )
            ),
            wp_kses_post( get_the_title() )
          )
        );

        wp_link_pages(
          array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universal' ),
            'after'  => '</div>',
          )
        );
      ?>
    </div><!-- end.post-content/содержимое поста -->
    <!-- Подвал поста -->
    <footer class="post-footer">
      <?php
        $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal' ) );
        if ( $tags_list ) {
          /* translators: 1: list of tags. */
          printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        // Поделиться в соцсетях
        meks_ess_share();
      ?>

  </div><!-- end .container -->
      <!-- Подключаем сайдбар статьями из категории -->
  <div class="widget-category-articles">
    <div class="container">
      <?php get_sidebar('post'); ?>
    </div>
  </div><!-- end .widget-category-articles -->

  <div class="container">
    </footer><!-- end.post-footer -->
  </div><!-- end.container -->

</article>