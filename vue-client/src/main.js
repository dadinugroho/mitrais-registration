import Vue from 'vue'
import VueI18n from 'vue-i18n'
import Vuelidate from 'vuelidate';
import App from './App.vue'
import translations from "./resources/translations";

Vue.use(VueI18n);
Vue.use(Vuelidate);

const i18n = new VueI18n({
  locale: 'en',
  fallbackLocale: 'en',
  silentTranslationWarn: process.env.NODE_ENV === 'production',
  messages: translations
})

new Vue({
  el: '#app',
  i18n,
  render: h => h(App)
})
