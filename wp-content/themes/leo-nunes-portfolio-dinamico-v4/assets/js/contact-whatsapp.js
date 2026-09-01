/**
 * Formulário de Contato — abre o WhatsApp com a mensagem pronta.
 * Substitui o antigo envio via AJAX/e-mail (assets/vendor/php-email-form/validate.js).
 */
(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form[data-whatsapp-phone]');

  forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();

      let phone   = form.getAttribute('data-whatsapp-phone');
      let errorEl = form.querySelector('.error-message');
      let sentEl  = form.querySelector('.sent-message');

      errorEl.classList.remove('d-block');
      sentEl.classList.remove('d-block');

      if (!phone) {
        errorEl.innerHTML = 'Número de WhatsApp não configurado. Tente novamente mais tarde.';
        errorEl.classList.add('d-block');
        return;
      }

      let nome     = form.querySelector('[name="name"]').value.trim();
      let email    = form.querySelector('[name="email"]').value.trim();
      let assunto  = form.querySelector('[name="subject"]').value.trim();
      let mensagem = form.querySelector('[name="message"]').value.trim();

      let texto = 'Olá! Meu nome é ' + nome + '.\n' +
        'Assunto: ' + assunto + '\n' +
        'E-mail: ' + email + '\n\n' +
        mensagem;

      let url = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(texto);

      window.open(url, '_blank', 'noopener');

      sentEl.classList.add('d-block');
      form.reset();
    });
  });

})();
