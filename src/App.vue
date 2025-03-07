<template>
  <div class="vue-wp-app">
    <!-- Admin Settings Page Component -->
    <template v-if="isAdmin && isPluginPage">
      <nav class="admin-nav" v-if="isPluginPage">
        <router-link 
          v-for="route in routes" 
          :key="route.path" 
          :to="route.path"
          class="nav-link"
        >
          {{ route.name }}
        </router-link>
      </nav>
      <router-view></router-view>
    </template>
    
    <!-- Default Component for other contexts -->
    <div v-else class="default-view">
      <h1>{{ message }}</h1>
      <p>Running in: {{ isAdmin ? 'WordPress Admin' : 'Frontend' }}</p>
      <p>Current page: {{ currentPage }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      message: 'Vue.js WordPress App',
      isAdmin: false,
      isPluginPage: false,
      currentPage: '',
      menuSlugs: [],
      baseSlug: 'vue-wp-app',
      routes: []
    }
  },
  created() {
    // Get settings from WordPress
    const settings = window.vueWpSettings || {}
    this.menuSlugs = settings.menuSlugs || [this.baseSlug]
    this.baseSlug = settings.baseSlug || this.baseSlug
    
    // Generate routes from menu items
    if (settings.menuItems) {
      this.routes = settings.menuItems.map(item => ({
        path: item.route,
        name: item.title,
        slug: item.slug
      }))
    }
    
    // Check if we're in the WordPress admin area
    this.isAdmin = window.location.href.includes('/wp-admin/')
    
    // Check if we're on any of the plugin pages
    if (this.isAdmin) {
      const urlParams = new URLSearchParams(window.location.search)
      const page = urlParams.get('page')
      
      // Check if current page is one of our plugin pages
      this.isPluginPage = this.menuSlugs.includes(page)
      this.currentPage = page || 'dashboard'
      
      // If we're on a plugin page, update the router path
      if (this.isPluginPage) {
        const routePath = this.getRoutePathFromSlug(page)
        if (routePath && routePath !== this.$route.path) {
          this.$router.push(routePath)
        }
      }

      // Debug logging
      console.log('Plugin page check:', {
        page,
        isPluginPage: this.isPluginPage,
        menuSlugs: this.menuSlugs,
        routePath: this.getRoutePathFromSlug(page)
      })
    } else {
      this.currentPage = 'frontend'
    }
  },
  methods: {
    getRoutePathFromSlug(slug) {
      // Handle the main plugin page
      if (slug === this.baseSlug) return '/'
      
      // Find matching route for subpages
      const route = this.routes.find(r => 
        slug === this.baseSlug + r.slug
      )
      
      return route ? route.path : '/'
    }
  }
}
</script>

<style>
.vue-wp-app {
  padding: 20px;
  background: #f0f0f0;
  margin: 10px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.admin-nav {
  margin-bottom: 20px;
  padding: 10px 0;
  border-bottom: 1px solid #ddd;
}

.nav-link {
  margin-right: 15px;
  padding: 5px 10px;
  text-decoration: none;
  color: #444;
}

.nav-link.router-link-active {
  color: #2271b1;
  font-weight: bold;
}

.default-view {
  padding: 15px;
}
</style> 