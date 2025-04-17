<template>
  <div class="dashboard">
    <p>Welcome to the Vue WP App dashboard! <br/><b>Let's Build Something Amazing Together!</b></p>
    <div class="custom-fields-section">
      <h3>Custom Fields</h3>
      <div v-if="loading">Loading fields...</div>
      <div v-else-if="error" class="error-message">{{ error }}</div>
      <div v-else>
        <form @submit.prevent="saveCustomFields">
          <div class="field-group">
            <label for="email">Account Email:</label>
            <input type="text" v-model="customFields.email" />
          </div>

          <div class="field-group">
            <label for="sites">Active Websites:</label>
            <input type="number" v-model="customFields.sites" />
          </div>
          
          <div class="field-group">
            <label for="license">License:</label>
            <input type="text" v-model="customFields.license" />
          </div>
          
          <div class="field-group">
            <label for="api_key">API Key:</label>
            <input type="text" v-model="customFields.api_key" />
          </div>
          
          <div class="actions">
            <button type="submit" class="button button-primary" :disabled="saving">
              {{ saving ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>
        </form>
        
        <div v-if="saveSuccess" class="success-message">
          Data Saved Successfully.
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminDashboard',
  data() {
    return {
      customFields: {},
      loading: true,
      error: null,
      saveSuccess: false,
      saving: false,
    };
  },
  mounted() {
    this.fetchCustomFields();
  },
  methods: {
    async fetchCustomFields() {
      this.loading = true;
      this.error = null;
      
      try {        
        const response = await fetch(`/wp-json/${window.vueWpSettings?.menuSlug}/v1/custom-fields`, {
          method: 'GET',
          headers: {'Content-Type': 'application/json',
            'X-WP-Nonce': window.wpApiSettings?.nonce || ''
          }
        });
        
        if (!response.ok) {
          throw new Error('Failed to fetch custom fields');
        }
        
        const data = await response.json();
        this.customFields = data;
        console.log(data);
      } catch (error) {
        console.error('Error fetching custom fields:', error);
        this.error = 'Failed to fetch custom fields...';
      } finally {
        this.loading = false;
      }
    },
    
    async saveCustomFields() {
      this.saving = true;
      this.error = null;
      this.saveSuccess = false;
      
      try {
        const response = await fetch(`/wp-json/${window.vueWpSettings?.menuSlug}/v1/custom-fields`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': window.wpApiSettings?.nonce || ''
          },
          body: JSON.stringify(this.customFields)
        });
        
        if (!response.ok) {
          throw new Error('Failed to save custom fields');
        }
        console.log(response);
        
        const data = await response.json();
        this.customFields = data;
        this.saveSuccess = true;
        
        // Hide success message after 3 seconds
        setTimeout(() => {
          this.saveSuccess = false;
        }, 3000);
      } catch (error) {
        console.error('Error saving custom fields:', error);
        this.error = 'Failed to save custom fields. Please try again later.';
      } finally {
        this.saving = false;
      }
    },

  }
}
</script>
<style scoped>
.dashboard {
  padding: 20px;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.custom-fields-section {
  width: 80%;
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.field-group {
  margin-bottom: 15px;
}

.field-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: 600;
}

.field-group input[type="text"],
.field-group input[type="number"],
.field-group textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.error-message {
  color: #d63638;
  padding: 10px;
  background: #ffebe8;
  border: 1px solid #d63638;
  border-radius: 4px;
  margin-bottom: 15px;
}

.success-message {
  color: #00a32a;
  padding: 10px;
  background: #edfaef;
  border: 1px solid #00a32a;
  border-radius: 4px;
  margin-top: 15px;
}

.actions {
  margin-top: 20px;
}
</style> 