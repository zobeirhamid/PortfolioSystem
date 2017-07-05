import VueRouter from 'vue-router';
import auth from './auth';

let routes = [
    {
        path: '/', component: require('./views/Home')
    },
    {
        path: '/admin/login',
        component: require('./components/Login')
    },
    {
        name: 'project-details',
        path: '/projects/details/:slug',
        component: require('./views/ProjectDetails')
    },
    {
        name: 'admin-project-create',
        path: '/admin/projects/create',
        component: require('./views/ProjectCreate'),
        meta: {requiresAuth: true}
    },
    {
        name: 'admin-project-edit',
        path: '/admin/projects/:slug/edit',
        component: require('./views/ProjectEdit'),
        meta: {requiresAuth: true}
    },
    {
        name: 'admin-projects',
        path: '/admin',
        component: require('./views/AdminProjectList'),
        meta: {requiresAuth: true}
    },
    {
        name: 'admin-projects-sticky',
        path: '/admin/projects/sticky',
        component: require('./views/AdminProjectStickyList'),
        meta: {requiresAuth: true}
    },
    {
        name: 'admin-link-create',
        path: '/admin/links/create',
        component: require('./views/LinkCreate'),
        meta: {requiresAuth: true}
    },
    {
        name: 'admin-link-edit',
        path: '/admin/links/:id/edit',
        component: require('./views/LinkEdit'),
        meta: {requiresAuth: true}
    },
    {
        name: 'admin-links',
        path: '/admin/links',
        component: require('./views/AdminLinkList'),
        meta: {requiresAuth: true}
    },
    {
        path: "*",
        redirect: '/'
    }
];

const router = new VueRouter({ mode: 'history',
    routes,
    linkActiveClass: 'is-active',
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!auth.loggedIn()) {
      next({
        path: '/admin/login',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router;
