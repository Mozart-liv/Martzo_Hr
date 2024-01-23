import { createStore } from 'vuex'

export default createStore({
  state: {
    user: {},
    login: "",
  },
  getters: {
    userInfo: (state) => state.user,
    loginStatus: (state) => state.login,
  },
  mutations: {},
  actions: {
    setLoginStatus: ({ state }, value) => state.login = value,
    setUserData: ({ state }, value) => state.user = value,
  },
  modules: {},
});
