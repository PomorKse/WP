<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!--шапка поста-->
  <header class="entry-header <?php echo get_post_type(); ?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
    <?php
      if( has_post_thumbnail() ) {
        echo get_the_post_thumbnail_url(); 
        }
        else {
          echo get_template_directory_uri() . '/assets/img/img-default.png';
        }
    ?>) no-repeat center center;">

    <div class="container">
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
              <use xlink:href="' . get_template_directory_uri() . '/assets/img/sprite.svg#left-arrow"></use>
            </svg>' . esc_html__( 'Назад', 'universal-example' ) . '</span>',
            'next_text' => '<span class="post-nav-next">' . esc_html__( 'Вперед', 'universal-example' ) . 
            '<svg class="icon next-icon">
              <use xlink:href="' . get_template_directory_uri() . '/assets/img/sprite.svg#right-arrow"></use>
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
        <span class="date"><?php the_time( 'j F, H:i' ); ?></span>
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
              __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-example' ),
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
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universal-example' ),
            'after'  => '</div>',
          )
        );
      ?>
    </div><!-- end.post-content/содержимое поста -->
    <!-- Подвал поста -->
    <footer class="post-footer">
      <?php
        $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal-example' ) );
        if ( $tags_list ) {
          /* translators: 1: list of tags. */
          printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-example' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
      
      ?>
    </footer><!-- end.post-footer -->
  </div><!-- end.container -->

</article>