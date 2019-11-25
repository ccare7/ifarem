import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router/index'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    //路由动态加载

    //超级管理员信息
    obj1:{
      path: "/Admin",
      name:'admin',
      component:()=>import('../views/Admin'),
      children: [
        {
          path: 'System',
          name:'system',
          meta:{title:"系统管理"},
          component: ()=>import('../views/system/System'),
          children:[
            {
              path:"Password",
              name:"password",
              meta:{title:"密码修改"},
              component:()=>import('../views/system/Password')
            },
            {
              path: "Manager",
              name: "manager",
              meta:{title:"管理员管理"},
              component: () => import('../views/system/Manager')
            }
          ]
        },
      ]
      },
    obj2:{
      path: "/Admin",
      name:'admin',
      component:()=>import('../views/Admin'),
      children: [
        {
          path: 'System',
          name:'system',
          meta:{title:"系统管理"},
          component: ()=>import('../views/system/System'),
          children:[
            {
              path:"Password",
              name:"password",
              meta:{title:"密码修改"},
              component:()=>import('../views/system/Password')
            }
          ]
        },
      ]
    }
  },
  mutations: {
    loadRouter:function (state,level) {
      if(level==0){
          router.addRoutes([state.obj1]);
      }else{
          router.addRoutes([state.obj2]);
      }
    }
  },
  actions: {

  },
  modules: {

  }
})
