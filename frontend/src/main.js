import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import './assets/main.css'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import DetailsModal from './components/Dashboard/DetailsModal.vue'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.component('Header', Header)
app.component('Footer', Footer)
app.component('DetailsModal', DetailsModal)


app.mount('#app')
