import Vue from 'vue'
import VueRouter from 'vue-router'
import login from '../views/Login'

Vue.use(VueRouter)

const routes = [
  {
    path:'/Login',
    name:'login',
    component:login
  },
  {
    path: "/",
    redirect:'login'
  },
]

const router = new VueRouter({
  base: process.env.BASE_URL,
  routes,
})

export default router
