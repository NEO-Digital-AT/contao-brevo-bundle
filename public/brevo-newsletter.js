/* NEO Brevo Newsletter — progressive enhancement for the sign-up form.
 * Submits via fetch (JSON) and shows an inline status message; without JS the
 * form posts normally and the endpoint redirects to the configured page. */
(function () {
  'use strict';

  function collectLists(form) {
    var select = form.querySelector('select[name="lists"]');
    if (select) {
      return select.value ? [select.value] : [];
    }
    var checks = form.querySelectorAll('input[name="lists[]"]:checked');
    return Array.prototype.map.call(checks, function (c) { return c.value; });
  }

  function val(form, name) {
    var el = form.querySelector('[name="' + name + '"]');
    return el ? el.value : '';
  }

  // Consent can be a checkbox OR a hidden field in the form (depending on the
  // template: "signing up counts as consent"). A hidden field has no `checked` —
  // checking only that would ALWAYS send an empty consent, and the server would
  // reject the sign-up as invalid.
  function consentValue(form) {
    var el = form.querySelector('[name="consent"]');

    if (!el) { return ''; }
    if ('checkbox' === el.type) { return el.checked ? (el.value || '1') : ''; }

    return el.value || '';
  }

  function enhance(form) {
    var msg = form.querySelector('.brevo-nl__msg');
    var btn = form.querySelector('.brevo-nl__btn');

    function setMsg(text, kind) {
      if (!msg) { return; }
      msg.textContent = text || '';
      msg.className = 'brevo-nl__msg' + (kind ? ' is-' + kind : '');
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (form.dataset.busy) { return; }

      var payload = {
        mod: val(form, 'mod'),
        email: val(form, 'email'),
        website: val(form, 'website'),
        consent: consentValue(form),
        lists: collectLists(form)
      };

      form.dataset.busy = '1';
      if (btn) { btn.disabled = true; }
      setMsg('', '');

      fetch(form.getAttribute('action'), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
      })
        .then(function (r) { return r.json().catch(function () { return { status: 'send_failed' }; }); })
        .then(function (res) {
          var status = res && res.status;

          if (res && res.ok) {
            setMsg(msg && msg.dataset.success, 'ok');
            form.reset();
          } else if ('choose' === status) {
            setMsg(msg && msg.dataset.choose, 'err');
          } else if ('invalid' === status) {
            setMsg(msg && (msg.dataset.invalid || msg.dataset.generic), 'err');
          } else if ('rate_limited' === status) {
            setMsg(msg && (msg.dataset.limit || msg.dataset.generic), 'err');
          } else {
            setMsg(msg && msg.dataset.generic, 'err');
          }
        })
        .catch(function () { setMsg(msg && msg.dataset.generic, 'err'); })
        .then(function () {
          form.dataset.busy = '';
          if (btn) { btn.disabled = false; }
        });
    });
  }

  function init() {
    document.querySelectorAll('[data-brevo-form]').forEach(enhance);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
