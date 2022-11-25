import {createApp} from 'vue'
import {createStore} from 'vuex'
import createPersistedState from 'vuex-persistedstate'
// import app from '../app'
import menu from './modules/menu'
import user from './modules/user'
import { setCurrentLanguage } from '../utils'
 import  {setupI18n} from'../i18n.js'
import { createI18n} from 'vue-i18n'
import Cookies from 'js-cookie'


export default createStore({
    plugins:[
        createPersistedState({
            paths: ['currentUser','user'],
            storage: {
                getItem: (key) => Cookies.get(key),
                setItem: (key, value) =>
                Cookies.set(key, value, { expires: 7}),
                removeItem: (key) => Cookies.remove(key),
            },
        })
    ],
  state: {
  },
  mutations: {
    changeLang(state, payload) {

        setupI18n(payload)
      setCurrentLanguage(payload);

    }
  },
  actions: {
    setLang({ commit }, payload) {
      commit('changeLang', payload)
    }
  },
  modules: {
    menu,
    user,
  }
})
