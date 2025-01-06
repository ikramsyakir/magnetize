import Swal from "sweetalert2";

import _ from "lodash";
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// If page expired (419)
window.axios.interceptors.response.use(
    response => response,
    async error => {
        if (error.response && 419 === error.response.status) {
            await Swal.fire({
                icon: 'error',
                title: window.messages.oops,
                text: window.messages.page_expired_try_again,
                allowOutsideClick: false,
                allowEscapeKey: false,
                heightAuto: false,
            }).then(function () {
                window.location.reload();
            });
        }

        return Promise.reject(error)
    }
)

// Remove '"#_=_"' from socialite callback
if (window.location.hash === "#_=_") {
    history.replaceState
        ? history.replaceState(null, null, window.location.href.split("#")[0])
        : window.location.hash = "";
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     luster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
