import './bootstrap';
import auth from './auth';
import router from './routes';

window.router = router;
const app = new Vue({
    el: '#app',
    data: {
        auth
    },

    router
});

