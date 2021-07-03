import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
library.add(fab)

import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas)

import { far } from '@fortawesome/free-regular-svg-icons'
library.add(far)

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false

import 'bootstrap'
import 'bootstrap/scss/bootstrap.scss'
import './assets/css/starter.css'
// import './assets/scss/main.scss'

createApp(App).use(router).mount('#app')
