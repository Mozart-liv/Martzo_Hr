import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import LoginView from '../views/LoginPage.vue'
import store from '@/store'

const routes: Array<RouteRecordRaw> = [
  {
    path: "/login",
    name: "login",
    component: LoginView,
  },
  {
    path: "/",
    name: "register",
    component: () => import("../views/RegisterPage.vue"),
  },
  {
    path: "/home",
    name: "home",
    component: () => import("../views/HomePage.vue"),
  },
  //employee 
  {
    path: "/employee",
    name: "employee",
    component: () => import("../views/employee/EmployeePage.vue"),
  },
  {
    path: "/employee/create",
    name: "create#employee",
    component: () => import("../views/employee/CreateEmployee.vue"),
  },
  {
    path: "/employee/update",
    name: "update#employee",
    component: () => import("../views/employee/UpdateEmployee.vue"),
  },
  {
    path: "/employee/detail",
    name: "employeeDetail",
    component: () => import("../views/employee/EmployeeDetail.vue"),
  },

  //profile
  {
    path: "/profile",
    name: "profile",
    component: () => import("../views/profile/profilePage.vue"),
  },
  {
    path: "/profile/passwordchange",
    name: "passwordchange",
    component: () => import("../views/profile/passwordChg.vue"),
  },
];


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

// router.beforeEach((to, from, next) => {
//   console.log(store.getters.loginStatus);
//   if (to.name !== 'login' && store.getters.loginStatus === "") {
//     return next({
//       name: 'login'
//     })
//   } else {
//     next()
//   }

// });
export default router
