import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import Vuelidate from 'vuelidate'
import { i18n } from './i18n'
import eventBus from './event-bus'
import realTimeClient from './real-time-client'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library as faLibrary } from '@fortawesome/fontawesome-svg-core'
import {
  faHome, faSearch, faPlus, faEllipsisH, faUserPlus, faListUl, faWindowMaximize,
  faUser, faPaperclip, faArchive, faPencilAlt, faComment, faUndo, faTrashAlt, faSpinner
} from '@fortawesome/free-solid-svg-icons'

// Set up FontAwesome
faLibrary.add(faHome, faSearch, faPlus, faEllipsisH, faUserPlus, faListUl, faWindowMaximize,
  faUser, faPaperclip, faArchive, faPencilAlt, faComment, faUndo, faTrashAlt, faSpinner)
Vue.component('font-awesome-icon', FontAwesomeIcon)

// Bootstrap axios
axios.defaults.baseURL = '/api'
axios.defaults.headers.common.Accept = 'application/json'
axios.interceptors.response.use(
  response => response,
  (error) => {
    return Promise.reject(error)
  }
)

// Enable Vuelidate
Vue.use(Vuelidate)
Vue.config.productionTip = false
Vue.prototype.$bus = eventBus
// Vue.prototype.$rt = realTimeClient

const app = new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
