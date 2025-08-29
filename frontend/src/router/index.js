import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '@/views/Index.vue'
import News from '@/views/News.vue'
import NewsDetails from '@/views/NewsDetails.vue'
import Impacts from '@/views/Impacts.vue'
import ImpactDetails from '@/views/ImpactDetails.vue'
import Contact from '@/views/Contact.vue'
import About from '@/views/About.vue'

import Dashboard from '@/views/dashboard/Index.vue'
import AdminUsers from '@/views/dashboard/users/Index.vue'
import AdminNews from '@/views/dashboard/news/Index.vue'
import AdminImpacts from '@/views/dashboard/impacts/Index.vue'
import AdminAbout from '@/views/dashboard/about/Index.vue'
import AdminContacts from '@/views/dashboard/contacts/Index.vue'
import AdminSettings from '@/views/dashboard/settings/Index.vue'

import AuthLogin from '@/views/auth/login/Index.vue'
import AuthSignUp from '@/views/auth/registration/Index.vue'
import NotFound from '@/views/NotFound.vue'

const router = createRouter({
  history: createWebHashHistory(import.meta.env.VITE_API_BASE_URL),
  routes: [
    { path: '/', name: 'Index', component: Home },
    { path: '/news', name: 'News', component: News },
    {
      path: '/news/:id',
      name: 'NewsDetails',
      component: NewsDetails,
      props: true,
    },
    { path: '/impacts', name: 'Impacts', component: Impacts },
    {
      path: '/impacts/:id',
      name: 'ImpactDetails',
      component: ImpactDetails,
      props: true,
    },
    { path: '/about-us', name: 'About', component: About },
    { path: '/contact-us', name: 'Contact', component: Contact },

    { path: '/login', component: AuthLogin },
    { path: '/register', component: AuthSignUp },

    {
      path: '/dashboard',
      // meta: { requireAuth: true },
      children: [
        { path: '/dashboard/', component: Dashboard },
        { path: '/dashboard/users', component: AdminUsers },
        { path: '/dashboard/news', component: AdminNews },
        { path: '/dashboard/impacts', component: AdminImpacts },
        { path: '/dashboard/contacts', component: AdminContacts },
        { path: '/dashboard/about', component: AdminAbout },
        { path: '/dashboard/settings', component: AdminSettings },
      ],
    },
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
  ],
})

export default router
