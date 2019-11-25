import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

//element-ui 的引入
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

//axios
import axios from 'axios'
import VueAxios from 'vue-axios'

//路由守卫
router.beforeEach((to,from,next)=>{
  if(to.name =='login' || sessionStorage.getItem("username")){
    next();
  }else{
    next({name:"login"})
  }
});
if(sessionStorage.getItem('level')){
let level = sessionStorage.getItem('level')
store.commit('loadRouter',level);
}
Vue.config.productionTip = false;
Vue.use(ElementUI);
Vue.use(VueAxios, axios);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
