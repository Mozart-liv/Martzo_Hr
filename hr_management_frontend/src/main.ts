import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'


// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import "@mdi/font/css/materialdesignicons.css";

const vuetify = createVuetify({
  components,
  directives,
})

import "ant-design-vue/dist/reset.css";
import { DatePicker } from "ant-design-vue";

createApp(App)
  .use(store)
  .use(vuetify)
  .use(router)
  .use(DatePicker)
  .mount("#app");
