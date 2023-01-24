// =========================================================
// * Vue Material Dashboard - v1.4.0
// =========================================================
//
// * Product Page: https://www.creative-tim.com/product/vue-material-dashboard
// * Copyright 2019 Creative Tim (https://www.creative-tim.com)
// * Licensed under MIT (https://github.com/creativetimofficial/vue-material-dashboard/blob/master/LICENSE.md)
//
// * Coded by Creative Tim
//
// =========================================================
//
// * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

//scss loader
require("./assets/scss/material-dashboard.scss");

import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App";
import store from "./store.js";
// router setup
import routes from "./routes/routes";

// Plugins
import GlobalComponents from "./globalComponents";
import GlobalDirectives from "./globalDirectives";
import Notifications from "./components/NotificationPlugin";

// MaterialDashboard plugin
import MaterialDashboard from "./material-dashboard";

//Calendar
import VCalendar from "v-calendar";

//Icon
//Icon

//Import chartist
import Chartist from "chartist";

// configure router
const router = new VueRouter({
    routes, // short for routes: routes
    linkExactActiveClass: "nav-item active",
});

var permissions = JSON.parse(localStorage.getItem("permissions"));

Vue.prototype.$permissions = permissions;
Vue.prototype.$Chartist = Chartist;

router.beforeEach((to, from, next) => {
    if (to.meta && to.meta.permissions && permissions) {
        var routePermissions = to.meta.permissions
        if (to.name == 'Reports') {
            if (permissions.some(val => val.startsWith('print'))) {
                next()
            } else {
                next({name: 'Dashboard'})
            }
        } else {
            let modulePermissions = []
            routePermissions.map(val => {
                modulePermissions.push('search ' + val)
                modulePermissions.push('write ' + val)
                modulePermissions.push('delete ' + val)
                modulePermissions.push('restore ' + val)
                modulePermissions.push('print ' + val)
                modulePermissions.push('portal ' + val)
            })
            if (modulePermissions.some(val => permissions.includes(val))) {
                next()
            } else {
                next({name: 'Dashboard'})
            }
        }
    } else {
        next()
    }
})

Vue.use(VueRouter);
Vue.use(MaterialDashboard);
Vue.use(GlobalComponents);
Vue.use(GlobalDirectives);
Vue.use(Notifications);
Vue.use(VCalendar);

/* eslint-disable no-new */
new Vue({
    el: "#app",
    render: (h) => h(App),
    router,
    data: {
        Chartist: Chartist,
    },
    store,
});
