<?php
//Добавление нового виджета Recent_Posts_Widget
 
class Recent_Posts_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: recent_posts_widget
			__( 'Published recently', 'universal' ),
			array( 'description' => __( 'Number of posts', 'universal' ), 'classname' => 'widget-recent-posts', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_posts_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
    $title = $instance['title'];
    $count = $instance['count'];

		echo $args['before_widget'];

		if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="widget-recent-posts-wrapper">';
			global $post;
			$recent_posts = get_posts([ 
				'posts_per_page' => $count,
				'order'          => 'ASC'
			]);
			
			foreach( $recent_posts as $post ){
				setup_postdata( $post );
				?>
				<a href="#" class="recent-posts-link">
					<img src="<?php if( has_post_thumbnail() ) {
														echo get_the_post_thumbnail_url(null, 'thumbnail'); 
													}
													else {
														echo get_template_directory_uri() . '/assets/img/img-default.png';
													}
										?>" alt="">
					<div class="recent-post-info">
						<h4><?php echo mb_strimwidth(get_the_title(), 0, 35, "..."); ?></h4>
						<span class="recent-post-time">
						<!-- Определяем человеко-понятное время-->
						<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
									echo "$time_diff назад"; ?>
						</span>
					</div>
				</a> <!-- end .recent-post-link -->

				<?php 
			}
			
			echo '</div>';
			wp_reset_postdata(); // Сбрасываем $post
			echo '<a href="" class="widget-recent-posts-readmore">Read more</a>';
			echo $args['after_widget'];
    }
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
    $title = @ $instance['title'] ?: _e( 'Recent:' );
    $count = @ $instance['count'] ?: '7';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
    <p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts:', 'universal' ); ?></label> 
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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_recent_posts_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_recent_posts_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('recent_posts_widget_script', $theme_url .'/recent_posts_widget_script.js' );
	}

	// стили виджета
	function add_recent_posts_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_recent_posts_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.recent_posts_widget a{ display:inline; }
		</style>
		<?php
	}
} 

