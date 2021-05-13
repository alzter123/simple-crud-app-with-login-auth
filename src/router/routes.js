
const routes = [
  {
    path: '', component: () => import('pages/Index.vue'),
  },
  { path: '/',
      component: () => import('layouts/MainLayout.vue'), 
      children: [
        {
          path: '/adminpage',
          component: () => import('pages/AdminPage.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/userpage',
          component: () => import('pages/UserPage.vue'),
          meta: {
            requiresAuth: true
          }
        }, 
        {
          path: '/logout',
          component: () => import('pages/Logout.vue'),
          meta: {
            requiresAuth: true
          }
        },],
  },
    

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
