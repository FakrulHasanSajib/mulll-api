// src/components/LoginRegister.vue

<template>
  <div class="login-register-container">
    <div class="form-card">
      <h2 class="title">{{ isLogin ? 'লগইন করুন' : 'রেজিস্টার করুন' }}</h2>
      
      <!-- ফর্মের ভেতরের অংশ -->
      <form @submit.prevent="isLogin ? handleLogin() : handleRegister()">
        
        <!-- রেজিস্ট্রেশনের জন্য নাম এবং শপের নাম -->
        <div v-if="!isLogin">
          <div class="form-group">
            <label for="name">নাম</label>
            <input type="text" id="name" v-model="form.name" required>
          </div>
          <div class="form-group">
            <label for="role">ভূমিকা</label>
            <select id="role" v-model="form.role">
              <option value="customer">কাস্টমার</option>
              <option value="vendor">ভেন্ডর</option>
            </select>
          </div>
          <div class="form-group" v-if="form.role === 'vendor'">
            <label for="shop_name">শপের নাম</label>
            <input type="text" id="shop_name" v-model="form.shop_name" required>
          </div>
        </div>

        <!-- লগইন এবং রেজিস্ট্রেশন উভয়ের জন্য ইমেইল ও পাসওয়ার্ড -->
        <div class="form-group">
          <label for="email">ইমেইল</label>
          <input type="email" id="email" v-model="form.email" required>
        </div>
        <div class="form-group">
          <label for="password">পাসওয়ার্ড</label>
          <input type="password" id="password" v-model="form.password" required>
        </div>

        <!-- সাবমিট বাটন -->
        <button type="submit" class="submit-button">
          {{ isLogin ? 'লগইন' : 'রেজিস্টার' }}
        </button>
      </form>
      
      <!-- টগল বাটন -->
      <p class="toggle-text">
        {{ isLogin ? 'নতুন অ্যাকাউন্ট তৈরি করতে চান?' : 'আগের অ্যাকাউন্ট আছে?' }}
        <a href="#" @click.prevent="isLogin = !isLogin">
          {{ isLogin ? 'রেজিস্টার' : 'লগইন' }}
        </a>
      </p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      isLogin: true, // এটি সত্য হলে লগইন ফর্ম দেখাবে, মিথ্যা হলে রেজিস্ট্রেশন
      form: {
        name: '',
        email: '',
        password: '',
        role: 'customer',
        shop_name: ''
      },
    };
  },
  methods: {
    // লগইন করার জন্য মেথড
    async handleLogin() {
      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          email: this.form.email,
          password: this.form.password,
        });

        // লগইন সফল হলে টোকেন সংরক্ষণ
        localStorage.setItem('authToken', response.data.token);
        alert('লগইন সফল হয়েছে!');
        // এখানে আপনি ব্যবহারকারীকে ড্যাশবোর্ড পেজে রিডিরেক্ট করতে পারেন
        console.log(response.data.user);
      } catch (error) {
        alert('লগইন করতে সমস্যা হয়েছে। অনুগ্রহ করে তথ্য যাচাই করুন।');
        console.error('Login error:', error);
      }
    },

    // রেজিস্ট্রেশন করার জন্য মেথড
    async handleRegister() {
      try {
        const payload = {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
          role: this.form.role,
        };

        if (this.form.role === 'vendor') {
          payload.shop_name = this.form.shop_name;
        }

        const response = await axios.post('http://localhost:8000/api/register', payload);

        // রেজিস্ট্রেশন সফল হলে টোকেন সংরক্ষণ
        localStorage.setItem('authToken', response.data.token);
        alert('রেজিস্ট্রেশন সফল হয়েছে!');
        // এখানে আপনি ব্যবহারকারীকে ড্যাশবোর্ড পেজে রিডিরেক্ট করতে পারেন
        console.log(response.data.user);
      } catch (error) {
        alert('রেজিস্ট্রেশন করতে সমস্যা হয়েছে। অনুগ্রহ করে তথ্য যাচাই করুন।');
        console.error('Registration error:', error);
      }
    },
  },
};
</script>
