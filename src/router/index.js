import { createRouter, createWebHashHistory } from 'vue-router'
import AdminDashboard from '../components/Dashboard.vue'
import AdminSettings from '../components/AdminSettings.vue'
import AdminTools from '../components/Tools.vue'

// Get menu configuration from WordPress
const settings = window.vueWpSettings || {}
const menuItems = settings.menuItems || []

// Map components to routes
const componentMap = {
  '': AdminDashboard,
  '-settings': AdminSettings,
  '-tools': AdminTools
}

// Generate routes from menu items
const routes = menuItems.map(item => ({
  path: item.route,
  name: item.title,
  component: componentMap[item.slug] || AdminDashboard
}))

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router 