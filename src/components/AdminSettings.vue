<template>
  <div class="vue-wp-admin-settings">
    <h2>Plugin Settings</h2>
    
    <div class="settings-container">
      <div class="settings-card">
        <h3>General Settings</h3>
        <div class="form-group">
          <label for="setting-frontend">Enable Frontend</label>
          <input 
            type="checkbox" 
            id="setting-frontend" 
            v-model="settings.enableFrontend"
            @change="saveSettings"
          >
          <span class="description">Display Vue app on frontend using shortcode</span>
        </div>
        
        <div class="form-group">
          <label for="setting-backend">Enable Admin</label>
          <input 
            type="checkbox" 
            id="setting-backend" 
            v-model="settings.enableBackend"
            @change="saveSettings"
          >
          <span class="description">Enable Vue app in WordPress admin</span>
        </div>
        
        <div class="form-group">
          <label for="setting-global">Enable Global Admin</label>
          <input 
            type="checkbox" 
            id="setting-global" 
            v-model="settings.enableBackendGlobal"
            @change="saveSettings"
          >
          <span class="description">Show Vue app on all admin pages (not just plugin page)</span>
        </div>
      </div>
      
      <div class="settings-card">
        <h3>Developer Settings</h3>
        <div class="form-group">
          <label for="setting-dev-mode">Development Mode</label>
          <input 
            type="checkbox" 
            id="setting-dev-mode" 
            v-model="settings.devMode"
            @change="saveSettings"
          >
          <span class="description">Use webpack dev server (localhost:8080)</span>
        </div>
        
        <div class="form-group">
          <label for="setting-debug">Debug Mode</label>
          <input 
            type="checkbox" 
            id="setting-debug" 
            v-model="settings.debugMode"
            @change="saveSettings"
          >
          <span class="description">Enable verbose console logging</span>
        </div>
      </div>
    </div>
    
    <div class="settings-footer">
      <div v-if="saveStatus" class="save-status" :class="saveStatus.type">
        {{ saveStatus.message }}
      </div>
      <button class="button button-primary" @click="saveSettings">Save Settings</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminSettings',
  data() {
    return {
      settings: {
        enableFrontend: true,
        enableBackend: true,
        enableBackendGlobal: false,
        devMode: true,
        debugMode: true,
        menuSlug: 'vue-wp-app' // Default value
      },
      saveStatus: null
    }
  },
  created() {
    // In a real implementation, you would fetch current settings from WordPress
    // For now, we'll use default values
    console.log('Admin Settings component created')
    this.loadSettings()
  },
  methods: {
    loadSettings() {
      // Mock loading settings from WordPress
      // In a real implementation, you would use the WordPress REST API
      console.log('Loading settings...')
      
      // Simulate API call with timeout
      setTimeout(() => {
        // For demo purposes, we're using hardcoded values
        // In a real implementation, these would come from your WordPress backend
        this.settings = {
          enableFrontend: window.vueWpSettings?.enableFrontend ?? true,
          enableBackend: window.vueWpSettings?.enableBackend ?? true,
          enableBackendGlobal: window.vueWpSettings?.enableBackendGlobal ?? false,
          devMode: window.vueWpSettings?.devMode ?? true,
          debugMode: window.vueWpSettings?.debugMode ?? true,
          menuSlug: window.vueWpSettings?.menuSlug ?? 'vue-wp-app'
        }
        
        console.log('Settings loaded:', this.settings)
      }, 300)
    },
    saveSettings() {
      // Mock saving settings to WordPress
      console.log('Saving settings:', this.settings)
      
      // Show saving status
      this.saveStatus = { type: 'info', message: 'Saving...' }
      
      // Simulate API call with timeout
      setTimeout(() => {
        // In a real implementation, you would use the WordPress REST API
        // to save these settings to your WordPress backend
        
        // Show success message
        this.saveStatus = { type: 'success', message: 'Settings saved successfully!' }
        
        // Clear status after a few seconds
        setTimeout(() => {
          this.saveStatus = null
        }, 3000)
      }, 800)
    }
  }
}
</script>

<style scoped>
.vue-wp-admin-settings {
  max-width: 1200px;
  margin: 20px 0;
}

.settings-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.settings-card {
  background: white;
  border: 1px solid #ccd0d4;
  border-radius: 4px;
  padding: 20px;
  flex: 1;
  min-width: 300px;
}

.form-group {
  margin-bottom: 15px;
  padding-bottom: 15px;
  border-bottom: 1px solid #f0f0f0;
}

.form-group:last-child {
  border-bottom: none;
}

.form-group label {
  display: block;
  font-weight: 600;
  margin-bottom: 5px;
}

.description {
  display: block;
  color: #666;
  font-size: 13px;
  margin-top: 5px;
}

.settings-footer {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.save-status {
  padding: 10px 15px;
  border-radius: 4px;
}

.save-status.success {
  background-color: #d4edda;
  color: #155724;
}

.save-status.error {
  background-color: #f8d7da;
  color: #721c24;
}

.save-status.info {
  background-color: #d1ecf1;
  color: #0c5460;
}
</style> 