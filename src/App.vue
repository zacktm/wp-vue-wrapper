<template>
  <div class="vue-wp-app">
    <!-- Admin Settings Page Component -->
    <AdminSettings v-if="isAdmin && isPluginPage" />
    
    <!-- Default Component for other contexts -->
    <div v-else class="default-view">
      <h1>{{ message }}</h1>
      <p>Running in: {{ isAdmin ? 'WordPress Admin' : 'Frontend' }}</p>
      <p>Current page: {{ currentPage }}</p>
    </div>
  </div>
</template>

<script>
import AdminSettings from './components/AdminSettings.vue'

export default {
  name: 'App',
  components: {
    AdminSettings
  },
  data() {
    return {
      message: 'Vue.js WordPress App',
      isAdmin: false,
      isPluginPage: false,
      currentPage: '',
      menuSlug: 'vue-wp-app' // Default value
    }
  },
  created() {
    // Get menu slug from settings if available
    this.menuSlug = window.vueWpSettings?.menuSlug || 'vue-wp-app'
    
    // Check if we're in the WordPress admin area
    this.isAdmin = window.location.href.includes('/wp-admin/')
    
    // Check if we're on the plugin settings page
    if (this.isAdmin) {
      const urlParams = new URLSearchParams(window.location.search)
      const page = urlParams.get('page')
      this.isPluginPage = page === this.menuSlug // Use the menu slug from settings
      this.currentPage = page || 'dashboard'
    } else {
      this.currentPage = 'frontend'
    }
    
    console.log('Vue App Created!', {
      location: this.isAdmin ? 'WordPress Admin' : 'Frontend',
      isPluginPage: this.isPluginPage,
      page: this.currentPage,
      menuSlug: this.menuSlug,
      path: window.location.pathname,
      timestamp: new Date().toISOString()
    })
  },
  mounted() {
    console.log("App component mounted");
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

.default-view {
  padding: 15px;
}
</style> 