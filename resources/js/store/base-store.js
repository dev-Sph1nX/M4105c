import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    theme: 'unknow',
    color: 'unknow_text'
  },
  mutations: {
    changeTheme(state, user) {
      switch(user.id_role){
        case 1:
          state.theme = 'demandeur'
          break;
        case 2:
          state.theme = 'operateur'
          break;
        case 3:
          state.theme = 'responsable'
          break;
        default:
          state.theme = 'unknow'
      }
    },
    changeColor(state, user) {
      switch(user.id_role){
        case 1:
          state.color = 'demandeur_text'
          break;
        case 2:
          state.color = 'operateur_text'
          break;
        case 3:
          state.color = 'responsable_text'
          break;
        default:
          state.color = 'unknow_text'
      }
    }
  }
})