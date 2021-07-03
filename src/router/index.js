import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
const DEFAULT_TITLE = 'Favoritos'

const routes = [
  {
    path: '/',
    name: 'Home',
    meta: { title: DEFAULT_TITLE + ' - Início' },
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    meta: { title: DEFAULT_TITLE + ' - About' },
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    meta: { title: DEFAULT_TITLE + ' - Erro 404' },
    component: () => import(/* webpackChunkName: "notfound" */ '../views/NotFound.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.afterEach((to) => {
  document.title = to.meta.title || DEFAULT_TITLE;
});

export default router
