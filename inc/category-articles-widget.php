<?php
//Добавление нового виджета Category_Articles_Widget
  
class Category_Articles_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
    // вызов конструктора выглядит так:
    // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
    parent::__construct(
      'category_articles_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: category_articles_widget
      __( 'This category articles', 'universal' ),
      array( 'description' => __( 'This category articles', 'universal' ), 'classname' => 'widget-category-articles', )
    );

    // скрипты/стили виджета, только если он активен
    if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
      add_action('wp_enqueue_scripts', array( $this, 'add_category_articles_widget_scripts' ));
      add_action('wp_head', array( $this, 'add_category_articles_widget_style' ) );
    }
  }

  /**
   * Вывод виджета во Фронт-энде
   *
   * @param array $args     аргументы виджета.
   * @param array $instance сохраненные данные из настроек
   */
  function widget( $args, $instance ) {
    $count = $instance['count'];

    echo $args['before_widget'];

    if ( ! empty( $count ) ) {
      echo '<div class="widget-category-articles-wrapper">';
      
      //Объявляем глобальную переменную
      global $post;
      $currentId=get_the_ID();
      $category_needed=get_the_category();
      $category_needed=$category_needed[0];
      $posts = get_posts([ 
        'posts_per_page' => $count,
        'category'       => $category_needed->cat_ID,
        'exclude'        => $currentId
      ]);

      foreach($posts as $post) :
        ?>
          <div class="widget-category-articles-item-wrapper">
            <a href="<?php echo get_the_permalink(); ?>" class="widget-category-articles-link">
              <img src="<?php if( has_post_thumbnail() ) {
                                echo get_the_post_thumbnail_url(null, 'thumbnail'); 
                              }
                              else {
                                echo get_template_directory_uri() . '/assets/img/img-default.png';
                              }
                        ?>" alt="">
              <h4 class="widget-category-articles-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, "..."); ?></h4>
              <div class="widget-category-articles-info">
                <div class="views">
                  <svg class="icon views-icon">
                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#views"></use>
                  </svg>
                  <span class="views-counter"><?php comments_number('0', '1', '%'); ?></span>
                </div>
                <div class="comments">
                  <svg class="icon comments-icon">
                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/sprite.svg#comment"></use>
                  </svg>
                  <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                </div>
              </div>
            </a> <!-- end .category-articles-link -->
          </div>
        <?php
      endforeach;
      echo '</div>';
      wp_reset_postdata(); // Сбрасываем $post
      echo $args['after_widget'];
    }
  }

  /**
   * Админ-часть виджета
   *
   * @param array $instance сохраненные данные из настроек
   */
  function form( $instance ) {
    $count = @ $instance['count'] ?: '4';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
    </p>
    <?php 
  }

  /**
   * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance новые настройки
   * @param array $old_instance предыдущие настройки
   *
   * @return array данные которые будут сохранены
   */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_category_articles_widget_scripts() {
    // фильтр чтобы можно было отключить скрипты
    if( ! apply_filters( 'show_category_articles_widget_script', true, $this->id_base ) )
      return;

    $theme_url = get_stylesheet_directory_uri();

    wp_enqueue_script('category_articles_widget_script', $theme_url .'/category_articles_widget_script.js' );
  }

  // стили виджета
  function add_category_articles_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_category_articles_widget_style', true, $this->id_base ) )
      return;
    ?>
    <style type="text/css">
      .category_articles_widget a{ display:inline; }
    </style>
    <?php
  }

}

// регистрация Category_Articles_Widget в WordPress
function category_articles_widget() {
register_widget( 'Category_Articles_Widget' );
}
add_action( 'widgets_init', 'category_articles_widget' );

?>