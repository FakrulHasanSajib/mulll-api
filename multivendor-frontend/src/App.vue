<template>
  <div id="app">
    <header class="app-header">
      <h1 class="app-title">মাল্টি-ভেন্ডর মার্কেটপ্লেস</h1>
      <nav class="auth-nav">
        <button v-if="user" @click="logout" class="logout-btn">লগআউট</button>
        <div v-else>
          <button @click="showAuthModal = true" class="login-btn">লগইন / রেজিস্টার</button>
        </div>
      </nav>
    </header>

    <main class="app-main">
      <div v-if="user">
        <VendorDashboard :user="user" />
      </div>
      <div v-else>
        <ProductList />
      </div>
    </main>

    <div v-if="showAuthModal" class="modal-overlay">
      <AuthModal @close="showAuthModal = false" @login-success="handleLoginSuccess" />
    </div>
  </div>
</template>

<script>
import AuthModal from './components/AuthModal.vue';
import VendorDashboard from './components/VendorDashboard.vue';
import ProductList from './components/ProductList.vue';
import axios from 'axios';

export default {
  name: 'App',
  components: {
    AuthModal,
    VendorDashboard,
    ProductList,
  },
  data() {
    return {
      user: null,
      showAuthModal: false,
    };
  },
  mounted() {
    this.checkLoginStatus();
  },
  methods: {
    async checkLoginStatus() {
      const token = localStorage.getItem('authToken');
      if (token) {
        try {
          const response = await axios.get('http://localhost:8000/api/user', {
            headers: {
              'Authorization': `Bearer ${token}`
            }
          });
          this.user = response.data;
        } catch (error) {
          console.error('লগইন স্ট্যাটাস চেক করতে সমস্যা হয়েছে:', error);
          localStorage.removeItem('authToken');
          this.user = null;
        }
      }
    },
    handleLoginSuccess(user) {
      this.user = user;
      this.showAuthModal = false;
    },
    async logout() {
      try {
        const token = localStorage.getItem('authToken');
        await axios.post('http://localhost:8000/api/logout', null, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });
        localStorage.removeItem('authToken');
        this.user = null;
        alert('সফলভাবে লগআউট করা হয়েছে!');
      } catch (error) {
        console.error('লগআউট করতে সমস্যা হয়েছে:', error);
      }
    },
  },
};