import $ from 'jquery';

console.log('login.js loaded');
console.log('window.$ in login.js =', window.$);

$.ajax({
    url: '/save-data',
    type: 'GET',
    data: {
        name: 'John',
        email: 'john@example.com'
    },
    success: function(response) {
        console.log(response);
    },
    error: function(error) {
        console.log(error);
    }
});