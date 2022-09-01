import './bootstrap';

import {createApp} from 'vue'
import router from './router'
import App from './Page/layouts/App.vue'

createApp(App).use(router).mount('#app')