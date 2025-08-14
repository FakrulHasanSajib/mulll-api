// src/components/ProductList.vue

<template>
  <div class="product-list">
    <h3 class="product-list-title">সব প্রোডাক্ট</h3>
    <div v-if="products.length === 0">
      <p>কোনো প্রোডাক্ট পাওয়া যায়নি।</p>
    </div>
    <div v-else class="product-grid">
      <div v-for="product in products" :key="product.id" class="product-card">
        <h4>{{ product.name }}</h4>
        <p class="product-price">মূল্য: {{ product.price }} টাকা</p>
        <p class="vendor-name">বিক্রেতা: {{ product.vendor.user.name }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      products: [],
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get('http://localhost:8000/api/products');
        this.products = response.data;
      } catch (error) {
        console.error('প্রোডাক্ট আনতে সমস্যা হয়েছে:', error);
      }
    },
  },
};
</script>