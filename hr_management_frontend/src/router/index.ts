import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import LoginView from '../views/LoginPage.vue'
import store from '@/store'

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "login",
    component: LoginView,
    alias: "/login",
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

  //department
  {
    path: "/department",
    name: "department",
    component: () => import("../views/department/DepartmentPage.vue"),
  },
  {
    path: "/department/create",
    name: "create#department",
    component: () => import("../views/department/CreateDepartment.vue"),
  },
  {
    path: "/department/update",
    name: "update#department",
    component: () => import("../views/department/UpdateDepartment.vue"),
  },

  //department
  {
    path: "/role",
    name: "role",
    component: () => import("../views/role/RolePage.vue"),
  },
  {
    path: "/role/create",
    name: "create#role",
    component: () => import("../views/role/CreateRole.vue"),
  },
  {
    path: "/role/update",
    name: "update#role",
    component: () => import("../views/role/UpdateRole.vue"),
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
  {
    path: "/profile",
    name: "update#profile",
    component: () => import("../views/profile/UpdateProfile.vue"),
  },

  //company setting
  {
    path: "/company",
    name: "company",
    component: () => import("../views/companySetting/CompanySetting.vue"),
  },
  {
    path: "/company/update",
    name: "update#company",
    component: () => import("../views/companySetting/UpdateCompanySetting.vue"),
  },
];


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  console.log(store.getters.getToken);
  if (
    to.name !== "login" &&
    store.getters.getToken === ""
  ) {
    return next({
      name: "login",
    });
  } else {
    next();
  }

});
export default router
