window._ = require('lodash');

window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpsRequest';
window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;