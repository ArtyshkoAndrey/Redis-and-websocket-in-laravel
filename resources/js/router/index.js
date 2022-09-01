import {createRouter, createWebHistory} from 'vue-router'

// Change how dynamic pages are loaded

const routes = [
  {
    path: '/',
    name: 'index',
    component: () => import('../Page/Index.vue'),
  }
];

export default createRouter({
  history: createWebHistory(),
  routes
})