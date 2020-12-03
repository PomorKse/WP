<?php
/*
Template Name: Страница контакты
Template Post Type: page
*/
get_header(); ?>
  <section class="section-dark">
    <div class="container">
     <h1 class="section-title"><?php the_title(); ?></h1>
     <div class="contacts-wrapper">
      <div class="contacts-left">
        <h2 class="contacts-title">Через форму обратной связи<br><i>-Форма ручками</i></h2>
        <form action="#" class="contacts-form" method="POST">
          <input name="contact_name" type="text" class="reset input contacts-input" placeholder="Ваше имя">
          <input name="contact_email" type="email" class="reset input contacts-input" placeholder="Ваш Email">
          <textarea name="contact_comment" class="reset textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
          <button type="submit" class="button more">Отправить</button>
          <p class="after-submit">Ваша заявка принята, мы свяжемся с Вами в ближайшее время</p>
        </form>
        <h2 class="contacts-title"><i>Форма через плагин</i></h2>
        <?php echo do_shortcode('[contact-form-7 id="158" title="Контактная форма" html_class="contacts-form"]'); ?>
      </div><!-- end .contacts-left -->
      <div class="contacts-right">
        <h2 class="contacts-title">Или по этим контактам</h2>
        <?php 
        // проверяем установлены ли кастомные поля-email, address, phone
        $email = get_post_meta(get_the_ID(), 'email', true); 
        $address = get_post_meta(get_the_ID(), 'address', true);

        if ($email) echo '<a href="mailto:' . $email . '">' . $email. '</a>';
        if ($address) echo '<address>' . $address . '</address>';

        ?>
        <!--вывод через плагин ACF-->

        <a href="tel:<?php the_field('phone') ?>"><?php the_field('phone') ?></a>

      </div><!-- end .contacts-right -->
     </div><!-- end .contacts-wrapper -->
    </div><!-- end .container -->
  </section>
<?php get_footer();
