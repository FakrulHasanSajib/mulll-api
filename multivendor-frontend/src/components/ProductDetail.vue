// src/components/ProductDetail.vue

<template>
  <div class="product-detail-container">
    <button @click="$emit('back')">ফিরে যান</button>
    <div v-if="loading" class="loading">
      <p>প্রোডাক্ট লোড হচ্ছে...</p>
    </div>
    <div v-else-if="product" class="product-card">
      <h2 class="title">{{ product.name }}</h2>
      <p class="description">{{ product.description }}</p>
      <div class="product-meta">
        <p class="price">মূল্য: {{ product.price }} টাকা</p>
        <p class="stock">স্টক: {{ product.stock }}</p>
        <p class="vendor">বিক্রেতা: {{ product.vendor.user.name }}</p>
      </div>
      <button class="add-to-cart-btn" @click="addToCart">অর্ডারের জন্য যোগ করুন</button>
    </div>
    <div v-else class="error">
      <p>প্রোডাক্টটি খুঁজে পাওয়া যায়নি।</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['productId'],
  data() {
    return {
      product: null,
      loading: true,
    };
  },
  mounted() {
    this.fetchProduct();
  },
  methods: {
    async fetchProduct() {
      this.loading = true;
      try {
        const response = await axios.get(`http://localhost:8000/api/products/${this.productId}`);
        this.product = response.data;
      } catch (error) {
        console.error('প্রোডাক্ট আনতে সমস্যা হয়েছে:', error);
      } finally {
        this.loading = false;
      }
    },
    // কার্টে প্রোডাক্ট যোগ করার জন্য ইভেন্ট নির্গত করি
    addToCart() {
      // এখানে আমরা প্রোডাক্টের আইডি এবং পরিমাণ পাঠাতে পারি।
      // আপাতত আমরা শুধু প্রোডাক্ট অবজেক্টটি পাঠাচ্ছি।
      this.$emit('add-to-cart', this.product);
      alert(`${this.product.name} কার্টে যোগ করা হয়েছে!`);
    }
  },
};

