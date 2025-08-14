// src/components/CustomerDashboard.vue

<template>
  <div class="dashboard-container">
    <div class="dashboard-card">
      <h2 class="title">কাস্টমার ড্যাশবোর্ড</h2>
      <p>স্বাগতম, {{ user.name }}!</p>

      <!-- এখানে কাস্টমারের সব অর্ডার দেখানো হবে -->
      <div class="section-card">
        <h3>আমার অর্ডারসমূহ</h3>
        <p v-if="orders.length === 0">আপনার কোনো অর্ডার নেই।</p>
        <!-- এখানে অর্ডারের তালিকা রেন্ডার করার লজিক থাকবে -->
      </div>
      
      <!-- এখানে কাস্টমার সব প্রোডাক্ট দেখতে পাবে -->
      <div class="section-card">
        <h3>সব প্রোডাক্ট দেখুন</h3>
        <!-- এখানে প্রোডাক্ট লিস্ট কম্পোনেন্টটি ব্যবহার করা যেতে পারে -->
      </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['user'],
  data() {
    return {
      orders: [],
    };
  },
  mounted() {
    // এখানে আমরা API কল করে কাস্টমারের সব অর্ডার আনব
    // যেমন:
    // this.fetchOrders();
  },
  methods: {
    // অর্ডার আনার জন্য একটি মেথড
    async fetchOrders() {
      try {
        const token = localStorage.getItem('authToken');
        const response = await axios.get('http://localhost:8000/api/orders', {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });
        this.orders = response.data;
      } catch (error) {
        console.error('অর্ডার আনতে সমস্যা হয়েছে:', error);
      }
    },
  },
};
</script>

