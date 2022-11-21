import {createApp} from 'vue'
import {createStore} from 'vuex'
import createPersistedState from 'vuex-persistedstate'
// import app from '../app'
import menu from './modules/menu'
import user from './modules/user'
import { setCurrentLanguage } from '../utils'




export default createStore({
    plugins:[
        createPersistedState()
    ],
  state: {
  },
  mutations: {
    changeLang(state, payload) {
        console.log(payload);
        createApp().$i18n.locale = payload
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
