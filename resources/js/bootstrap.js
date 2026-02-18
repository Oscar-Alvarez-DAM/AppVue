import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Establecer baseURL relativa (funciona en cualquier dominio)
window.axios.defaults.baseURL = '/api';

