<?php get_header(); ?>

<body>
  
</body>
<main class="front-page-header">
  <div class="container">
    <div class="hero">
      <div class="left">
          <?php
              //Объявляем глобальную переменную
              global $post;

              $myposts = get_posts([ 
                'numberposts'   => 1,
                'category_name' => 'javascript'
              ]);

              //проверяем есть ли посты
              if( $myposts ){
                //если есть, запускаем цикл
                foreach( $myposts as $post ){
                  setup_postdata( $post );
                  ?>
                  <!-- Выводим записи -->
                  <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="post-thumb">
                  <?php $author_id = get_the_author_meta('ID'); ?>
                  <a href="<?php echo get_author_posts_url($author_id); ?>" class="author">
                    <img src="<?php echo get_avatar_url($author_id)?>" class="avatar" alt="">
                    <div class="author-bio">
                      <span class="author-name"><?php the_author(); ?></span>
                      <span class="author-rank">Должность</span>
                    </div>
                  </a>
                  <div class="post-text">
                    <?php 
                      foreach (get_the_category()  as $category) {
                        printf(
                          '<a href="%s" class="category-link %s">%s</a>',
                          esc_url( get_category_link($category) ),
                          esc_html( $category -> slug ),
                          esc_html( $category -> name )
                        );
                      }
                    ?>
                    <h2 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, "..."); ?></h2>
                    <a href="<?php echo get_the_permalink(); ?>" class="more">Читать далее</a>
                  </div>
            <?php 
              }
            } else {
              ?><p>Постов нет</p><?php
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
      </div>
      <!-- end .left -->
      <div class="right">
        <h3 class="recommend">Рекомендуем</h3>
        <ul class="posts-list">
        <?php
              //Объявляем глобальную переменную
              global $post;

              $myposts = get_posts([ 
                'numberposts'   => 5,
                'category_name' => 'css, javascript, web-design, html'
              ]);

              //проверяем есть ли посты
              if( $myposts ){
                //если есть, запускаем цикл
                foreach( $myposts as $post ){
                  setup_postdata( $post );
                  ?>
                  <!-- Выводим записи -->
          <li class="post">
            <?php 
              foreach (get_the_category()  as $category) {
                printf(
                  '<a href="%s" class="category-link %s">%s</a>',
                  esc_url( get_category_link($category) ),
                  esc_html( $category -> slug ),
                  esc_html( $category -> name )
                );
              }
            ?>
            <a class="post-permalink" href="<?php echo get_the_permalink(); ?>">
              <h4 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, "..."); ?></h4>
            </a>
          </li>
          <?php 
              }
            } else {
              ?><p>Постов нет</p><?php
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
        </ul>
      </div>
      <!-- end .right -->
    </div>
    <!-- end .hero -->

  </div>
  <!-- end .container -->

</main>
<div class="container">
  <ul class="article-list">
    <?php
      //Объявляем глобальную переменную
       global $post;

       $myposts = get_posts([ 
        'numberposts'   => 4,
        'category_name' => 'article',
        'offset'        => '1'
      ]);

       //проверяем есть ли посты
       if( $myposts ){
        //если есть, запускаем цикл
         foreach( $myposts as $post ){
          setup_postdata( $post );
          ?>
           <!-- Выводим записи -->
          <li class="article-item">
            <a class="article-permalink" href="<?php echo get_the_permalink(); ?>">
              <h4 class="article-title"><?php echo wp_trim_words(get_the_title(), 6, '...' ); ?></h4>
            </a>
            <img src="<?php if( has_post_thumbnail() ) {
                              echo get_the_post_thumbnail_url(); 
                            }
                            else {
                              echo get_template_directory_uri() . '/assets/img/img-default.png';
                            }
                      ?>" alt="">
          </li>
    <?php 
      }
    } else {
      ?><p>Постов нет</p><?php
    }
    wp_reset_postdata(); // Сбрасываем $post
    ?>
  </ul>
  <!-- ./article-list -->

  <div class="main-grid">
    <ul class="article-grid">
      <?php		
        global $post;
        // формируем запрос в базу данных
      $query = new WP_Query( [
        // получаем 7 постов
        'posts_per_page'   => 7,
        'category__not_in' => 23
      ] );

      // проверяем, есть ли посты
      if ( $query->have_posts() ) {
        //создаем переменную-счетчик постов
        $cnt = 0;
        //пока посты есть, выводим их
        while ( $query->have_posts() ) {
          $query->the_post();
          // увеличиваем счетчик постов
          $cnt++;
          switch ($cnt) {
            //выводим первый пост
            case '1':
              ?>
                <li class="article-grid-item article-grid-item-1">
                  <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                    <img src="<?php if( has_post_thumbnail() ) {
                                      echo get_the_post_thumbnail_url(); 
                                    }
                                    else {
                                      echo get_template_directory_uri() . '/assets/img/img-default.png';
                                    }
                              ?>" alt="" class="article-grid-thumb">
                    <span class="category-name"><?php $category = get_the_category(); echo $category[0]->name; ?></span>
                    <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 48, " ..."); ?></h4>
                    <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 130, " ..."); ?></p>
                    <div class="article-grid-info">
                      <div class="author">
                        <?php $author_id = get_the_author_meta('ID'); ?>
                        <img src="<?php echo get_avatar_url($author_id) ?>" alt="" class="author-avatar">
                        <span class="author-name"><strong><?php the_author(); ?></strong> : <?php the_author_meta('description'); ?></span>
                      </div>
                      <!-- end .author -->
                      <div class="comments">
                        <svg class="icon comments-icon">
                          <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#comment"></use>
                        </svg>
                        <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                      </div>
                      <!-- end .comments -->

                    </div>
                    <!-- end .article-grid-info -->
                  </a>
                </li>
              <?php
              break;

            //выводим второй пост
            case '2':
              ?>
                <li class="article-grid-item article-grid-item-2">
                  <img src="<?php if( has_post_thumbnail() ) {
                                    echo get_the_post_thumbnail_url(); 
                                  }
                                  else {
                                    echo get_template_directory_uri() . '/assets/img/img-default.png';
                                  }
                            ?>" alt="" class="article-grid-thumb">
                  <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                    <span class="tag">
                      <?php $posttags = get_the_tags();
                      if ($posttags) {
                        echo $posttags[0]->name . ' ';
                      } ?>
                    </span>
                    <span class="category-name"><?php $category = get_the_category(); echo $category[0]->name; ?></span>
                    <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, " ..."); ?></h4>
                    <div class="article-grid-info">
                      <div class="author">
                        <?php $author_id = get_the_author_meta('ID'); ?>
                        <img src="<?php echo get_avatar_url($author_id) ?>" alt="" class="author-avatar">
                        <div class="author-info">
                          <span class="author-name"><strong><?php the_author(); ?></strong></span>
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
                        </div>
                        <!-- end .author-info -->
                      </div>
                      <!-- end .author -->
                    </div>
                    <!-- end .article-grid-info -->
                  </a>
                </li>
              <?php
              break;

            //выводим третий пост
            case '3':
              ?>
                <li class="article-grid-item article-grid-item-3">
                  <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                    <img src="<?php if( has_post_thumbnail() ) {
                                      echo get_the_post_thumbnail_url(); 
                                    }
                                    else {
                                      echo get_template_directory_uri() . '/assets/img/img-default.png';
                                    }
                              ?>" alt="" class="article-thumb">
                    <h4 class="article-grid-title"><?php echo the_title(); ?></h4>
                  </a>
                </li>
              <?php
              break;

            //выводим остальные посты
            default:
            ?>
              <li class="article-grid-item article-grid-item-default">
                <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                      <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 42, " ..."); ?></h4>
                      <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 86, " ..."); ?></p>
                      <span class="date"><?php the_time( 'j F' ); ?></span>
                </a>
              </li>
              <?php
              break;
          }

          ?>
          <!-- Вывода постов, функции цикла: the_title() и т.д. -->
          <?php 
        }
      } else {
        // Постов не найдено
      }

      wp_reset_postdata(); // Сбрасываем $post
      ?>
    </ul>
    <!-- end .article-grid -->

    <!-- Подключаем сайдбар сверху -->
    <?php get_sidebar('home-top'); ?>

  </div>
  <!-- end .main-grid -->
</div>
<!-- end .container -->

<!--Блок расследования-->

<?php		
global $post;

$query = new WP_Query( [
	'posts_per_page' => 1,
	'category_name'  => 'investigation',
] );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
    ?>
    <section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)), url(<?php if( has_post_thumbnail() ) {
                  echo get_the_post_thumbnail_url(); 
                }
                else {
                  echo get_template_directory_uri() . '/assets/img/img-default.png';
                } ?>) no-repeat center center">
      <div class="container">
        <h2 class="investigation-title"><?php the_title(); ?></h2>
        <a href="<?php echo get_the_permalink(); ?>" class="more">Читать статью</a>
      </div>
    </section>
    
    <?php 
	}
} else {
	// Постов не найдено
}

wp_reset_postdata(); // Сбрасываем $post
?>
<!-- end .investigation -->

<div class="container">
  <div class="main-grid">
    <ul class="article-list-2">
      <?php		
        global $post;

        $query = new WP_Query( [
          'posts_per_page' => 6,
          'category_name' => 'hot, viewpoint, selection, news'
        ] );

        if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
            $query->the_post();
      ?>
            
      <li class="article-list-2-item">
        <a href="<?php the_permalink(); ?>" class="article-list-2-permalink">
          <img src="<?php if( has_post_thumbnail() ) {
                            echo get_the_post_thumbnail_url(); 
                          }
                          else {
                            echo get_template_directory_uri() . '/assets/img/img-default.png';
                          } ?>" alt="" class="article-list-2-thumb">
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
            <h4 class="article-list-2-title"><?php echo mb_strimwidth(get_the_title(), 0, 100, " ..."); ?></h4>
            <p class="article-list-2-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 200, " ..."); ?></p>
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
            </div>
            <!-- end .article-grid-info -->
          </div>
          <!-- end .article-list-2-item-wrapper -->
        </a>
        </li>

      <?php 
          }
        } else {
          // Постов не найдено
        }

        wp_reset_postdata(); // Сбрасываем $post
      ?>
      
    </ul>
    <!-- end .article-list-2 -->
    
    <!-- Подключаем сайдбар снизу -->
    <?php get_sidebar('home-bottom'); ?>

  </div>
  <!-- end .main-grid -->
</div>
<!-- end .container -->

<div class="special">
  <div class="container">
    <div class="special-grid">

      <!-- Левый раздел photo-report -->
      <?php		
        global $post;
                
        $query = new WP_Query( [
          'posts_per_page' => 1,
          'category_name' => 'photo-report'
          ] );
          
        if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
            $query->the_post();
      ?>

        <div class="photo-report">

          <!--Выводим слайдер с фото из записи-->

          <div class="swiper-container photo-report-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <?php $images = get_attached_media( 'image' ); 
                foreach ($images as $image) {
                  echo '<div class="swiper-slide"><img src ="';
                  print_r($image -> guid);
                  echo '"></div>';
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="photo-report-content">
          <?php 
          foreach (get_the_category() as $category) {
            printf(
              "<a href='%s' class='category-link'>%s</a>",
              esc_url( get_category_link($category) ),
              esc_html( $category -> name )
            );
          }
        ?>
          <?php $author_id = get_the_author_meta('ID'); ?>
          <a href="<?php echo get_author_posts_url($author_id); ?>" class="author">
            <img src="<?php echo get_avatar_url($author_id)?>" class="author-avatar" alt="">
            <div class="author-bio">
              <span class="author-name"><?php the_author(); ?></span>
              <span class="author-rank">Должность</span>
            </div>
          </a>

            <h3 class="photo-report-title"><?php the_title(); ?></h3>
            <a href="<?php echo get_the_permalink(); ?>" class="button photo-report-button">
              <svg class="icon photo-report-icon">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#images"></use>
              </svg>
              Смотреть фото
              <span class="photo-report-counter"><?php echo count($images); ?></span>
            </a>

        </div>

  
        </div>
        
        
      <?php 
          }
        } else {
          // Постов не найдено
        }
        
        wp_reset_postdata(); // Сбрасываем $post
      ?>
      <!-- end .photo-report -->

      <!-- Правый раздел other -->
      <div class="other">
        <!--Раздел карьера-->
        <?php		
        global $post;
        $query = new WP_Query( [
          'posts_per_page' => 1,
          'category_name'  => 'career',
        ] );
        if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
            $query->the_post();
        ?>
          <div class="career">
              <div class="career-content">
                <span class="category-link"><?php $category = get_the_category(); echo $category[0]->name; ?></span>
                <h2 class="career-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, " ..."); ?></h2>
                <p class="career-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 90, " ..."); ?></p>
                <a href="<?php echo get_the_permalink(); ?>" class="more">Читать статью</a>
              </div>
          </div>
            
        <?php 
          }
        } else {
          // Постов не найдено
        }
        wp_reset_postdata(); // Сбрасываем $post
        ?>
        <!-- end .career -->

        
        <!-- Выводим остальные посты -->

        <div class="other-default">
        <?php		
          global $post;

          $query = new WP_Query( [
            'posts_per_page' => 2,
          ] );

          if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
              $query->the_post();
              ?>
                <a href="<?php the_permalink(); ?>" class="other-default-item-permalink">
                      <h4 class="other-default-item-title"><?php echo mb_strimwidth(get_the_title(), 0, 30, " ..."); ?></h4>
                      <p class="other-default-item-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 75, " ..."); ?></p>
                      <span class="date"><?php the_time( 'j F' ); ?></span>
                </a>
              
        <?php 
            }
          } else {
            // Постов не найдено
          }
          wp_reset_postdata(); // Сбрасываем $post
        ?>

        </div>
        <!-- end .other-default -->
      </div>
      <!-- end .other -->
    </div>
    <!-- end .special-grid -->
  </div>
  <!-- end .container -->

</div>
<!-- end .special -->

<?php get_footer(); ?>
