// src/components/VendorDashboard.vue

<template>
  <div class="dashboard-container">
    <div class="dashboard-card">
      <h2 class="title">বিক্রেতা ড্যাশবোর্ড</h2>
      <p>স্বাগতম, {{ user.name }}!</p>
      
      <!-- এখানে বিক্রেতার সব প্রোডাক্ট দেখানো হবে -->
      <div class="section-card">
        <h3>আমার প্রোডাক্টসমূহ</h3>
        <p v-if="products.length === 0">কোনো প্রোডাক্ট পাওয়া যায়নি।</p>
        <!-- এখানে প্রোডাক্টের তালিকা রেন্ডার করার লজিক থাকবে -->
      </div>

      <!-- এখানে বিক্রেতার সব অর্ডার দেখানো হবে -->
      <div class="section-card">
        <h3>অর্ডার ম্যানেজমেন্ট</h3>
        <p v-if="orders.length === 0">কোনো নতুন অর্ডার নেই।</p>
        <!-- এখানে অর্ডারের তালিকা রেন্ডার করার লজিক থাকবে -->
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
      products: [],
      orders: [],
    };
  },
  mounted() {
    // এইখানে আমরা API কল করে বিক্রেতার প্রোডাক্ট এবং অর্ডার আনব
    // যেমন:
    // this.fetchProducts();
    // this.fetchOrders();
  },
  methods: {
    // প্রোডাক্ট আনার জন্য একটি মেথড
    async fetchProducts() {
      try {
        const token = localStorage.getItem('authToken');
        const response = await axios.get('http://localhost:8000/api/vendor/products', {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });
        this.products = response.data;
      } catch (error) {
        console.error('প্রোডাক্ট আনতে সমস্যা হয়েছে:', error);
      }
    },

    // অর্ডার আনার জন্য একটি মেথড
    async fetchOrders() {
        try {
        const token = localStorage.getItem('authToken');
        const response = await axios.get('http://localhost:8000/api/vendor/orders', {
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


