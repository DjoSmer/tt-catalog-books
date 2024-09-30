function subscribeInit() {
  const $form = $('#form-author-subscribe');

  const createAlert = (message, type) => {
    const alert = document.createElement('div');
    alert.classList.add('alert', `alert-${type}`, 'alert-dismissible', 'fade', 'show');
    alert.setAttribute('role', 'alert');
    alert.innerHTML = [
      `<div>${message}</div>`,
      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
    ].join('');

    setTimeout(() => {
      new bootstrap.Alert(alert).close();
    }, 2000);

    return alert;
  };

  $form.on('beforeSubmit', async function () {
    const form = this;
    const body = new FormData(form);
    const button = form.querySelector('button');

    button.disabled = 1;

    const res = await fetch(form.action, {
      headers: {
        Accept: 'application/json',
      },
      method: form.method,
      body,
    });

    const { errors, success, message } = await res.json();

    button.disabled = 0;

    if (errors) {
      $(this).yiiActiveForm('updateMessages', errors);
    }

    if (success) {
      form.append(createAlert(message, 'success'));
      form.reset();
    }
  });

  $form.on('submit', (event) => {
    event.preventDefault();
  });
}

$(subscribeInit);
