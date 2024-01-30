import { createStore } from 'vuex'

export default createStore({
  state: {
    user: {},
    token: "",
  },
  getters: {
    userInfo: (state) => state.user,
    getToken: (state) => state.token,
  },
  mutations: {},
  actions: {
    setToken: ({ state }, value) => state.token = value,
    setUserData: ({ state }, value) => state.user = value,
  },
  modules: {},
});
