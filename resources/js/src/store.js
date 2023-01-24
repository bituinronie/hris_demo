import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

const store = new Vuex.Store({
    plugins: [
        createPersistedState({
            storage: window.sessionStorage,
        }),
    ],
    state: {
        //default State when logging in as admin
        userStatusAction: "add",
        currentSelectionUserId: null,
        currentSelectionUserName: null,
        currentTabSelection: null,
        userInfo: null,
    },
    mutations: {
        changeUserStatusAction: function (state, newAction) {
            state.userStatusAction = newAction;
        },
        changecurrentSelectionUserId: function (state, newSelection) {
            state.currentSelectionUserId = newSelection;
            console.log(state.currentSelectionUserId);
        },
        changeCurrentTabSelection: function (state, newSelection) {
            state.currentTabSelection = newSelection;
        },
        changeCurrentSelectionUserName: function (state, newSelection) {
            state.currentSelectionUserName = newSelection;
            console.log(state.currentSelectionUserName);
        },
        changeUserInfo: function (state, userInfo) {
            state.userInfo = userInfo;
        },
    },
});
export default store;
