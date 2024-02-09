/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************!*\
  !*** ./src/blocks/auth-modal/frontend.js ***!
  \*******************************************/
// scripts should always be downloaded on the bottom but this EventListener will help us with that
document.addEventListener('DOMContentLoaded', () => {
  const openModalBtn = document.querySelectorAll('.open-modal');
  const modalEl = document.querySelector('.wp-block-auth-block-shortcode-auth-modal');
  const modalCloseEl = document.querySelectorAll('.modal-overlay, .modal-btn-close');
  openModalBtn.forEach(el => {
    el.addEventListener('click', event => {
      event.preventDefault();
      modalEl.classList.add('modal-show');
    });
  });
  modalCloseEl.forEach(el => {
    el.addEventListener('click', event => {
      event.preventDefault();
      modalEl.classList.remove('modal-show');
    });
  });
  const tabs = document.querySelectorAll('.tabs a');
  const signinForm = document.querySelector('#signin-tab');
  const signupForm = document.querySelector('#signup-tab');
  tabs.forEach(tab => {
    tab.addEventListener('click', event => {
      event.preventDefault();
      tabs.forEach(currentTab => {
        currentTab.classList.remove('active-tab');
      });
      event.currentTarget.classList.add('active-tab');
      const activeTab = event.currentTarget.getAttribute('href');
      if (activeTab === '#signin-tab') {
        signinForm.style.display = 'block';
        signupForm.style.display = 'none';
      } else {
        signinForm.style.display = 'none';
        signupForm.style.display = 'block';
      }
    });
  });
  signupForm.addEventListener('submit', async event => {
    event.preventDefault();
    const signupFieldset = signupForm.querySelector('fieldset');
    signupFieldset.setAttribute('disabled', true);
    const signupStatus = signupForm.querySelector('#signup-status');
    signupStatus.innerHTML = `
            <div class="modal-status modal-status-info">
                Please wait! We are creating your account!
            </div>
        `;
    const formData = {
      first_name: signupForm.querySelector('#su-first-name').value,
      last_name: signupForm.querySelector('#su-last-name').value,
      username: signupForm.querySelector('#su-username').value,
      email: signupForm.querySelector('#su-email').value,
      password: signupForm.querySelector('#su-password').value,
      userRegisterType: signupForm.querySelector('#su-user-type').textContent
    };
    const response = await fetch(abs_auth_rest.signup, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(formData)
    });
    const responseJSON = await response.json();
    if (responseJSON.status === 2) {
      signupStatus.innerHTML = `
                <div class="modal-status modal-status-success">
                    Success! Your account has been created.
                </div>
            `;

      // we force page to refresh to view page as logged in user
      location.reload();
    } else if (responseJSON.status === 4) {
      signupFieldset.removeAttribute('disabled');
      signupStatus.innerHTML = `
                <div class="modal-status modal-status-danger">
                    Unable to create account! You need a stronger password.
                    <small>Requirements 8 characters min, uppercase, lowercase, number, special character</small>
                </div>
            `;
    } else {
      signupFieldset.removeAttribute('disabled');
      signupStatus.innerHTML = `
                <div class="modal-status modal-status-danger">
                    Unable to create account! Please try again later.
                </div>
            `;
    }
  });
  signinForm.addEventListener('submit', async event => {
    event.preventDefault();
    const signinFieldset = signinForm.querySelector('fieldset');
    const signinStatus = signinForm.querySelector('#signin-status');
    signinFieldset.setAttribute('disabled', true);
    signinStatus.innerHTML = `
            <div class="modal=status modal-status-info">
                Please wait! We are logging you in.
            </div>
        `;
    const formData = {
      user_login: signinForm.querySelector('#si-email').value,
      password: signinForm.querySelector('#si-password').value,
      remember_me: signinForm.querySelector('#si-remember-me').checked
    };
    const response = await fetch(abs_auth_rest.signin, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(formData)
    });
    const responseJSON = await response.json();
    if (responseJSON.status === 2) {
      signinStatus.innerHTML = `
                <div class="modal-status modal-status-success">
                    Success! You are now logged in.
                </div>
            `;
      location.reload();
    } else {
      signinFieldset.removeAttribute('disabled');
      signinStatus.innerHTML = `
                <div class="modal-status modal-status-danger">
                    Invalid credentials! Please try again later.
                </div>
            `;
    }
  });
});
/******/ })()
;
//# sourceMappingURL=frontend.js.map