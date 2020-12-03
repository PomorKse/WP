<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!--шапка поста-->
  <header class="entry-header <?php echo get_post_type(); ?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75))">

    <div class="container">
      <div class="lesson-header-nav">
            
        <!--Подключаем хлебные крошки-->
        <?php if ( function_exists( 'universal_breadcrumbs' ) ) universal_breadcrumbs(); ?>
      </div><!-- end .lesson-header-nav -->


          <div class="video">
            <?php 
            $tmp = get_field('video_link');
            if (stristr($tmp, 'youtube')) {
              $url = explode('?v=', $tmp); ?>
              <iframe width="100%" height="550" src="https://www.youtube.com/embed/<?php echo end($url); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php 
            } elseif (stristr($tmp, 'vimeo')) {
              $url = explode('/', $tmp); ?>
              <iframe src="https://player.vimeo.com/video/<?php echo end($url); ?>" width="100%" height="550" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            <?php
            } ?>
          </div>

          <div class="lesson-header-title-wrapper">
            <?php
              //Проверяем, точно ли мы на странице поста
              if ( is_singular() ) :
                the_title( '<h1 class="lesson-header-title">', '</h1>' );
              else :
                the_title( '<h2 class="lesson-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
              endif;
            ?>
          </div>

          <div class="post-header-info">
            <svg class="icon clock-icon">
              <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#clock"></use>
            </svg>
            <span class="date"><?php the_time( 'j F, H:i' ); ?></span>
          </div><!-- end .post-header-info -->

    </div><!-- end .container -->
	</header><!-- end.entry-header -->

  <!-- Содержимое поста -->
  <div class="container">
    <div class="lesson-content">
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
    </div><!-- end.lesson-content/содержимое поста -->
    <!-- Подвал поста -->
    <footer class="post-footer">
      <?php
        $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal-example' ) );
        if ( $tags_list ) {
          /* translators: 1: list of tags. */
          printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-example' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        // Поделиться в соцсетях
        meks_ess_share();
      ?>

    </footer><!-- end.post-footer -->
  </div><!-- end.container -->
</article>