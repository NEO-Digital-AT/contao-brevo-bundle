/* NEO Brevo Newsletter — sign-up form.
 * Submits via fetch (JSON) and shows an inline status message.
 *
 * Spam protection (since 1.1.0): as soon as the visitor starts filling in the
 * form, the script fetches a small proof-of-work task (ALTCHA format) from the
 * endpoint in data-challenge and solves it in the background with the browser's
 * own SHA-256 (crypto.subtle). The solution goes with the sign-up; without it the
 * server refuses. The visitor sees nothing of it. The server accepts a solution
 * only a few seconds after the task was handed out, so the script waits for that
 * if someone is very quick. */
(function () {
  'use strict';

  /** Seconds the server waits between task and solution (ProofOfWork::MIN_AGE), plus a margin. */
  var MIN_AGE_MS = 2500;

  function collectLists(form) {
    var select = form.querySelector('select[name="lists"]');
    if (select) {
      return select.value ? [select.value] : [];
    }
    var checks = form.querySelectorAll('input[name="lists[]"]:checked');
    return Array.prototype.map.call(checks, function (c) { return c.value; });
  }

  // Additional fields (Brevo standard attributes): { firstname: …, sms: … }.
  function collectFields(form) {
    var out = {};
    Array.prototype.forEach.call(form.querySelectorAll('[data-brevo-field]'), function (el) {
      out[el.getAttribute('data-brevo-field')] = el.value;
    });
    return out;
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

  function hex(buf) {
    return Array.prototype.map.call(new Uint8Array(buf), function (b) { return ('0' + b.toString(16)).slice(-2); }).join('');
  }

  function wait(ms) {
    return new Promise(function (resolve) { setTimeout(resolve, Math.max(0, ms)); });
  }

  /* Fetches a task and finds the number; resolves with the base64 payload. */
  function solve(url) {
    var started = Date.now();

    return fetch(url, { credentials: 'same-origin', cache: 'no-store', headers: { Accept: 'application/json' } })
      .then(function (r) {
        if (!r.ok) { throw new Error('challenge'); }
        return r.json();
      })
      .then(function (task) {
        if (!window.crypto || !window.crypto.subtle || !window.TextEncoder) { throw new Error('crypto'); }

        var enc = new TextEncoder();
        var max = task.maxnumber || 100000;
        var n = 0;

        function batch() {
          var jobs = [];
          for (var k = 0; k < 500 && n + k <= max; k++) {
            jobs.push(window.crypto.subtle.digest('SHA-256', enc.encode(task.salt + (n + k))));
          }
          if (!jobs.length) { throw new Error('unsolved'); }

          return Promise.all(jobs).then(function (hashes) {
            for (var j = 0; j < hashes.length; j++) {
              if (hex(hashes[j]) === task.challenge) {
                return btoa(JSON.stringify({ algorithm: task.algorithm, challenge: task.challenge, number: n + j, salt: task.salt, signature: task.signature }));
              }
            }
            n += hashes.length;
            return batch();
          });
        }

        return batch();
      })
      .then(function (payload) {
        return wait(MIN_AGE_MS - (Date.now() - started)).then(function () { return payload; });
      });
  }

  function enhance(form) {
    var msg = form.querySelector('.brevo-nl__msg');
    var btn = form.querySelector('.brevo-nl__btn');
    var challengeUrl = form.getAttribute('data-challenge') || '/api/brevo/challenge';
    var pending = null;

    function setMsg(text, kind) {
      if (!msg) { return; }
      msg.textContent = text || '';
      msg.className = 'brevo-nl__msg' + (kind ? ' is-' + kind : '');
    }

    function messageFor(status) {
      var d = msg ? msg.dataset : {};
      var map = { choose: d.choose, invalid: d.invalid, fields: d.fields, phone: d.phone, repeat: d.repeat, rate_limited: d.limit, verify: d.verify };

      return map[status] || d.generic;
    }

    // One task per sign-up: started when the visitor begins, renewed after each try.
    function prepare() {
      if (!pending) {
        pending = solve(challengeUrl).catch(function () { return ''; });
      }
      return pending;
    }

    form.addEventListener('focusin', prepare, { once: true });
    form.addEventListener('input', prepare, { once: true });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (form.dataset.busy) { return; }

      form.dataset.busy = '1';
      form.setAttribute('aria-busy', 'true');
      if (btn) { btn.disabled = true; }
      setMsg('', '');

      prepare()
        .then(function (altcha) {
          pending = null; // a solution counts once

          if (!altcha) {
            return { status: 'verify' };
          }

          return fetch(form.getAttribute('action'), {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
              mod: val(form, 'mod'),
              email: val(form, 'email'),
              fields: collectFields(form),
              website: val(form, 'website'),
              consent: consentValue(form),
              lists: collectLists(form),
              altcha: altcha
            })
          }).then(function (r) { return r.json().catch(function () { return { status: 'send_failed' }; }); });
        })
        .then(function (res) {
          if (res && res.ok) {
            setMsg(msg && msg.dataset.success, 'ok');
            form.reset();
          } else {
            setMsg(messageFor(res && res.status), 'err');
            prepare(); // the next try is ready sooner
          }
        })
        .catch(function () { setMsg(msg && msg.dataset.generic, 'err'); })
        .then(function () {
          form.dataset.busy = '';
          form.removeAttribute('aria-busy');
          if (btn) { btn.disabled = false; }
          // Themes that enable the button only for a valid address recalculate it.
          form.dispatchEvent(new Event('input', { bubbles: true }));
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
