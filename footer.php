  <footer class="footer">
    <div class="container">
    <div class="footer-form-wrapper">
      <h3 class="footer-form-title">Подпишитесь на нашу рассылку</h3>
      <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" class="footer-form">
        <!-- Поле Email (обязательно) -->
        <input required type="text" name="email" placeholder="Email"/>
        <!-- Токен списка -->
        <!-- Получить API ID на: https://app.getresponse.com/campaign_list.html -->
        <input type="hidden" name="campaign_token" value="Bef5A" />
        <!-- Добавить подписчика в цикл на определенный день (по желанию) -->
        <input type="hidden" name="start_day" value="0" />
        <!-- Кнопка подписаться -->
        <!-- Страница благодарности (по желанию) -->
        <input type="hidden" name="thankyou_url" value="<?php echo home_url( 'thankyou' ) ?>"/>
        <button type="submit">Подписаться</button>
      </form>
    </div><!-- end .footer-form -->
    <?php
      if ( ! is_active_sidebar( 'sidebar-footer' ) ) {
        return;
      }
      ?>

      <div class="footer-menu-bar">
        <?php dynamic_sidebar( 'sidebar-footer' ); ?>
      </div><!-- end.footer-menu-bar -->

      <div class="footer-info">
        <?php
          if( has_custom_logo() ){
                echo '<div class="logo">' . get_custom_logo() . '</div>';
              } else {
                echo '<span class="logo-name">' . get_bloginfo( 'name' ) . '</span>';
              }

          wp_nav_menu( [
            'theme_location'  => 'footer_menu',
            'container'       => 'nav', 
            'container_class' => 'footer-nav-wrapper', 
            'menu_class'      => 'footer-nav', 
            'echo'            => true
          ] );
        
        //Выводим виджет социальных сетей

        $instance = [
          'title'         => '',
          'link_facebook' => 'http://facebook.com',
          'link_twitter'  => 'http://twitter.com',
          'link_youtube'  => 'http://youtube.com'
        ];

        $args = [
          'before_widget' => '<div class="footer-social">',
          'after_widget'  => '</div>'
        ];
        
        the_widget( 'Social_Widget', $instance, $args );
        ?>
      </div>
      <!-- end .footer-info -->
      <div class="footer-text-wrapper">
        <?php
          if ( ! is_active_sidebar( 'sidebar-footer-text' ) ) {
            return;
          }
          dynamic_sidebar( 'sidebar-footer-text' );
        ?>
        <span class="footer-copyright"><?php echo '&copy; ' . date('Y'). ' ' . get_bloginfo('name'); ?></span>

      </div>
      <!-- end .footer-text-wrapper -->




    </div>
    <!-- end .container -->
  </footer>
  <?php wp_footer(); ?>
  </body>
</html>