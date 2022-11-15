import {createApp} from 'vue'
import {createStore} from 'vuex'

// import app from '../app'
import menu from './modules/menu'
import user from './modules/user'
import { setCurrentLanguage } from '../utils'



export default createStore({
  state: {
  },
  mutations: {
    changeLang(state, payload) {
      app.$i18n.locale = payload
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
