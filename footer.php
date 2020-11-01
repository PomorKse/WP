  <footer class="footer">
    <div class="container">
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
        wp_nav_menu( [
          'theme_location'  => 'footer_menu',
          'container'       => 'nav', 
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