import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/tailwind.css'

// Near the top of the file, add a timestamp for debugging
const initTime = new Date().toISOString();

// Check if we're in WordPress admin area
const isWordPressAdmin = window.location.href.includes('/wp-admin/')

// Check environment settings
const enableFrontend = process.env.VUE_APP_ENABLE_FRONTEND === 'true'
const enableBackend = process.env.VUE_APP_ENABLE_BACKEND === 'true'
const enableDebug = process.env.VUE_APP_ENABLE_DEBUG === 'true'


// Define initVueApp at the root level
function initVueApp() {
  const mountPoint = document.getElementById('vue-wp-app')
  if(enableDebug){
  console.log('Vue init attempt:', {
    time: new Date().toISOString(),
    initTime: initTime,
    mountPoint: mountPoint ? {
      id: mountPoint.id,
      parent: mountPoint.parentElement.tagName,
      location: window.location.href
    } : 'Not Found'
  });
}

  if (!mountPoint) {
    if(enableDebug){
    console.error('Vue mount point not found, retrying in 100ms...')
    }
    setTimeout(initVueApp, 100)
    return
  }

  if(enableDebug){
  console.log('Mounting Vue app to:', mountPoint)
  }
  const app = createApp(App)
  app.use(router)

  app.config.errorHandler = (err, vm, info) => {
    console.error('Vue Error:', err, info)
  }

  app.mount('#vue-wp-app')
  if(enableDebug){
  console.log('Vue app mounted successfully')
  }
}

// Only proceed if the current context is enabled
if ((isWordPressAdmin && enableBackend) || (!isWordPressAdmin && enableFrontend)) {
  if(enableDebug){
  console.log('Vue app main.js loaded, checking mount conditions:', {
    selector: '#vue-wp-app',
    exists: !!document.getElementById('vue-wp-app'),
    documentReady: document.readyState,
    timestamp: new Date().toISOString(),
    context: isWordPressAdmin ? 'admin' : 'frontend'
  })
}

  // Initialize when document is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVueApp)
  } else {
    initVueApp()
  }
} else {
  if(enableDebug){
  console.log('Vue app disabled for current context:', {
    isAdmin: isWordPressAdmin,
    enableFrontend,
    enableBackend
  })
}
} 