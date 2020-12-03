<?php get_header('post'); ?>
  <main class="site-main">
    
		<?php
    // запускаем цикл Wordpress, проверяем есть ли посты
    while ( have_posts() ) :
      //если пост есть, выводим содержимое
      the_post();
      
      // находим шаблон для вывода поста в папке template_parts
			get_template_part( 'template-parts/content', get_post_type() );

			// If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) :
        //находим файл сomment.php и выводим его
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
<?php get_footer(); ?>
