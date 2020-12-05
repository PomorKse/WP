<?php 
require "inc/downloader-widget.php";
require "inc/social-widget.php";
require "inc/recent-posts-widget.php";
require "inc/category-articles-widget.php";
require "inc/breadcrumps.php";

//Добавление расширенных возможностей
if ( ! function_exists( 'universal_theme_setup' ) ) :

  function universal_theme_setup() {

		//Подключение файлов перевода
		load_theme_textdomain( 'universal', get_template_directory() . '/languages' );
    //Добавление тэга title
    add_theme_support( 'title-tag' );

    //Добавление миниатюр
    add_theme_support( 'post-thumbnails', array( 'post' ) );

    //Добавление пользовательского логотипа
    add_theme_support( 'custom-logo', [
      'width'                  => 163,
	    'flex-height'            => true,
	    'header-text'            => 'Universal',
	    'unlink-homepage-logo'   => true,
    ] );

    //Регистрация меню
      register_nav_menus( [
        'header_menu' => 'Меню в шапке',
        'footer_menu' => 'Меню в подвале'
			] );
			
			add_action( 'init', 'register_post_types' );
			function register_post_types(){
				register_post_type( 'lesson', [
					'label'  => null,
					'labels' => [
						'name'               => __( 'Lessons', 'universal' ), // основное название для типа записи
						'singular_name'      => __( 'Lesson', 'universal' ), // название для одной записи этого типа
						'add_new'            => __( 'Add lesson', 'universal' ), // для добавления новой записи
						'add_new_item'       => __( 'Add lesson', 'universal' ), // заголовка у вновь создаваемой записи в админ-панели.
						'edit_item'          => __( 'Edit lesson', 'universal' ), // для редактирования типа записи
						'new_item'           => __( 'New lesson', 'universal' ), // текст новой записи
						'view_item'          => __( 'View lesson', 'universal' ), // для просмотра записи этого типа.
						'search_items'       => __( 'Search lesson', 'universal' ), // для поиска по этим типам записи
						'not_found'          => __( 'Not found', 'universal' ), // если в результате поиска ничего не было найдено
						'not_found_in_trash' => __( 'Not found in trash', 'universal' ), // если не было найдено в корзине
						'parent_item_colon'  => '', // для родителей (у древовидных типов)
						'menu_name'          => __( 'Lessons', 'universal' ), // название меню
					],
					'description'         => __( 'Video lesson section', 'universal' ),
					'public'              => true,
					// 'publicly_queryable'  => null, // зависит от public
					// 'exclude_from_search' => null, // зависит от public
					// 'show_ui'             => null, // зависит от public
					// 'show_in_nav_menus'   => null, // зависит от public
					'show_in_menu'        => true, // показывать ли в меню адмнки
					// 'show_in_admin_bar'   => null, // зависит от show_in_menu
					'show_in_rest'        => true, // добавить в REST API. C WP 4.7
					'rest_base'           => null, // $post_type. C WP 4.7
					'menu_position'       => 5,
					'menu_icon'           => 'dashicons-book-alt',
					'capability_type'   => 'post',
					//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
					//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
					'hierarchical'        => false,
					'supports'            => [ 'title', 'editor', 'custom-fields', 'thumbnail' ], // 'title','editor','author','excerpt','trackbacks','comments','revisions','page-attributes','post-formats'
					'taxonomies'          => [],
					'has_archive'         => true,
					'rewrite'             => true,
					'query_var'           => true,
				] );
			}

			// хук, через который подключается функция
			
			// регистрирующая новые таксономии (create_lesson_taxonomies)
			add_action( 'init', 'create_lesson_taxonomies' );

			// функция, создающая 2 новые таксономии "genres" и "teacher" для постов типа "lesson"
			function create_lesson_taxonomies(){

				// Добавляем древовидную таксономию 'genre' (как категории)
				register_taxonomy('genre', array('lesson'), array(
					'hierarchical'  => true,
					'labels'        => array(
						'name'              => _x( 'Genres', 'taxonomy general name', 'universal' ),
						'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'universal' ),
						'search_items'      =>  __( 'Search Genres', 'universal' ),
						'all_items'         => __( 'All Genres', 'universal' ),
						'parent_item'       => __( 'Parent Genre', 'universal' ),
						'parent_item_colon' => __( 'Parent Genre:', 'universal' ),
						'edit_item'         => __( 'Edit Genre', 'universal' ),
						'update_item'       => __( 'Update Genre', 'universal' ),
						'add_new_item'      => __( 'Add New Genre', 'universal' ),
						'new_item_name'     => __( 'New Genre Name', 'universal' ),
						'menu_name'         => __( 'Genre', 'universal' ),
					),
					'show_ui'       => true,
					'query_var'     => true,
					'rewrite'       => array( 'slug' => 'the_genre' ), // свой слаг в URL
				));

				// Добавляем НЕ древовидную таксономию 'teacher' (как метки)
				register_taxonomy('teacher', 'lesson',array(
					'hierarchical'  => false,
					'labels'        => array(
						'name'                        => _x( 'Teachers', 'taxonomy general name', 'universal' ),
						'singular_name'               => _x( 'Teacher', 'taxonomy singular name', 'universal' ),
						'search_items'                =>  __( 'Search Teachers', 'universal' ),
						'popular_items'               => __( 'Popular Teachers', 'universal' ),
						'all_items'                   => __( 'All Teachers', 'universal' ),
						'parent_item'                 => null,
						'parent_item_colon'           => null,
						'edit_item'                   => __( 'Edit Teacher', 'universal' ),
						'update_item'                 => __( 'Update Teacher', 'universal' ),
						'add_new_item'                => __( 'Add New Teacher', 'universal' ),
						'new_item_name'               => __( 'New Teacher Name', 'universal' ),
						'separate_items_with_commas'  => __( 'Separate teachers with commas', 'universal' ),
						'add_or_remove_items'         => __( 'Add or remove teachers', 'universal' ),
						'choose_from_most_used'       => __( 'Choose from the most used teachers', 'universal' ),
						'menu_name'                   => __( 'Teachers', 'universal' ),
					),
					'show_ui'       => true,
					'query_var'     => true,
					//'rewrite'       => array( 'slug' => 'the_teacher' ), // свой слаг в URL
				));
			}
  }
endif;  

  add_action( 'after_setup_theme', 'universal_theme_setup');
  
  //Подключение сайдбаров
  
  function universal_theme_widgets_init() {
    register_sidebar(
      array(
        'name'          => esc_html__( 'Front page sidebar-top', 'universal' ),
				'id'            => 'main-sidebar-top',
				'description'   => esc_html__( 'Add widgets here', 'universal' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
      )
		);
		register_sidebar(
      array(
        'name'          => esc_html__( 'Front page sidebar-bottom', 'universal' ),
				'id'            => 'main-sidebar-bottom',
				'description'   => esc_html__( 'Add widgets here', 'universal' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
      )
		);
		register_sidebar(
      array(
        'name'          => esc_html__( 'Footer menu', 'universal' ),
				'id'            => 'sidebar-footer',
				'description'   => esc_html__( 'Add elements here', 'universal' ),
        'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="footer-menu-title">',
        'after_title'   => '</h2>',
      )
		);
		register_sidebar(
      array(
        'name'          => esc_html__( 'Footer text', 'universal' ),
				'id'            => 'sidebar-footer-text',
				'description'   => esc_html__( 'Add text here', 'universal' ),
        'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '',
        'after_title'   => '',
      )
		);
		register_sidebar(
      array(
        'name'          => esc_html__( 'Post page sidebar', 'universal' ),
				'id'            => 'post-sidebar',
				'description'   => esc_html__( 'Add elements here', 'universal' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
      )
		);

  }
  add_action( 'widgets_init', 'universal_theme_widgets_init' );

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );

// регистрация Social_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );

// регистрация Recent_Posts_Widget в WordPress
function register_recent_posts_widget() {
	register_widget( 'Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );

  //Подключение стилей и скриптов
  function enqueue_universal_style() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'Roboto-Slab', '//fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
		wp_enqueue_style( 'swiper-slider', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', 'style', time());
		wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style', time());
		wp_deregister_script( 'jquery-core' );
		wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.5.1.min.js');
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, time(), true );	
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', 'swiper', time(), true );		
  }  
	add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

	//AJAX: цепляемся к событию wp_enqueue_scripts, добавляем свою функцию
	add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){

	// Первый параметр 'jquery' означает, что код будет прикреплен к скрипту с ID 'jquery'
	// 'jquery' должен быть добавлен в очередь на вывод, иначе WP не поймет куда вставлять код локализации
	// Заметка: обычно этот код нужно добавлять в functions.php в том месте где подключаются скрипты, после указанного скрипта
	wp_localize_script( 'jquery', 'adminAjax', 
		array(
			'url' => admin_url('admin-ajax.php')//создаем переменную adminAjax c путем до файла-обработчика
		)
	);  
}

add_action('wp_ajax_contacts_form', 'ajax_form');//цепляемся к событию wp_ajax_contacts_form(сами определили contacts_form в script.js), выполняя функцию ajax_form
add_action('wp_ajax_nopriv_contacts_form', 'ajax_form');//nopriv не только для админки, но и для фронта
function ajax_form() {
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_comment = $_POST['contact_comment'];
	$message = 'Пользователь ' . $contact_name . 'оставил сообщение ' . $contact_comment . '. Его адрес: ' . $contact_email;
	echo $message;
	wp_die();
	$headers = 'From: Kseniia Pomortseva <pomorzeva46@gmail.com>'; // "\r\n";
	
	$send_message = wp_mail('kseniia.pomortzeva@yandex.ru', 'Без темы', $message, $headers);
	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	if ($send_message){
		echo "Все получилось!";
	}
	else {
		echo "где-то ошибка!";
	}

	wp_die();
}
	
  //Добавляем фильтр к виджету с облаком-тегов (ловим событие widget_tag_cloud_args и запускаем свою функцию edit_widget_tag_cloud_args)
	add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args' );
	function edit_widget_tag_cloud_args($args){
		$args['unit'] = 'px';
		$args['largest'] = 14;
		$args['smallest'] = 14;	
		$args['number'] = 12;	
		$args['orderby'] = 'count';	
		return $args;
	}

  // отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}
// склоняем слова после числительных
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}