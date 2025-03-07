<template>
  <div class="vue-wp-app">
    <h1>{{ message }}</h1>
    <p>Running in: {{ isAdmin ? 'WordPress Admin' : 'Frontend' }}</p>
  </div>
</template>

<script>
export default {
  name: 'App',
  mounted() {
    console.log("Hello World from mounted hook");
  },
  data() {
    return {
      message: 'Vue.js WordPress App',
      isAdmin: false
    }
  },
  created() {
    // Check if we're in the WordPress admin area
    this.isAdmin = window.location.href.includes('/wp-admin/')
    
    console.log('Vue App Created!', {
      location: this.isAdmin ? 'WordPress Admin' : 'Frontend',
      path: window.location.pathname,
      timestamp: new Date().toISOString()
    })
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
</style> 