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

  //role
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

  //salary
  {
    path: "/salary",
    name: "salary",
    component: () => import("../views/salary/SalaryPage.vue"),
  },
  {
    path: "/salary/create",
    name: "create#salary",
    component: () => import("../views/salary/CreateSalary.vue"),
  },
  {
    path: "/salary/update",
    name: "update#salary",
    component: () => import("../views/salary/UpdateSalary.vue"),
  },

  //attendance management
  {
    path: "/attendance",
    name: "attendance",
    component: () => import("../views/attendance/AttendancePage.vue"),
  },
  {
    path: "/attendance/create",
    name: "create#attendance",
    component: () => import("../views/attendance/CreateAttendance.vue"),
  },
  {
    path: "/attendance/update",
    name: "update#attendance",
    component: () => import("../views/attendance/UpdateAttendance.vue"),
  },
  {
    path: "/attendance/overview",
    name: "attendanceOverview",
    component: () => import("../views/attendance/AttendanceOverview.vue"),
  },

  //payroll
  {
    path: "/payroll",
    name: "payroll",
    component: () => import("../views/Payroll.vue"),
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

  //project
  {
    path: "/project",
    name: "project",
    component: () => import("../views/project/ProjectPage.vue"),
  },
  {
    path: "/project/create",
    name: "create#project",
    component: () => import("../views/project/CreateProject.vue"),
  },
  {
    path: "/project/update",
    name: "update#project",
    component: () => import("../views/project/UpdateProject.vue"),
  },
  {
    path: "/project/detail",
    name: "detail#project",
    component: () => import("../views/project/ProjectDetail.vue"),
  },
  //for auth
  {
    path: "/myProject",
    name: "myProject",
    component: () => import("../views/project/MyProjectPage.vue"),
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
