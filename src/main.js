import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'

import 'bootstrap'
import 'bootstrap/scss/bootstrap.scss'
import './assets/css/starter.css'


createApp(App).use(router).mount('#app')
