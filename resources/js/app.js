import './bootstrap';
import $ from 'jquery';

window.$ = window.jQuery = $;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    }
});

import './user-login/login';
import './user-register/register';
