var mySwiper = new Swiper('.swiper-container', {
  // Optional parameters
  loop: true,

  autoplay: {
    delay: 5000,
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },
})

let menuToggle = $('.header-menu-toggle');
menuToggle.on('click', function (event) {
  event.preventDefault();
  $('.header-nav').slideToggle(200);
})

let contactsForm = $('.contacts-form');//создаем переменную с формой
contactsForm.on('submit', function (event) {
  event.preventDefault();
  let formData = new FormData(this);//в переменную formData записываем все содержимое .contacts-form
  formData.append('action', 'contacts_form');//добавили аттрибут action, который в админке найдет обработчик contacts_form

  //Формируем и отправляем запрос на сервер
  $.ajax({
    type: "POST",
    url: adminAjax.url,
    processData: false,
    contentType: false,
    data: formData,
    success: function (response) {
      alert('Ответ сервера: ' + response);
    },
    error: function(rs) {
      console.error(rs);
    }
  });
})