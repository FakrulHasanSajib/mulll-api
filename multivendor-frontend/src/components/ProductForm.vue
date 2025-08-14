// src/components/ProductForm.vue

<template>
  <div class="product-form-container">
    <h3 class="title">{{ isEditing ? 'প্রোডাক্ট এডিট করুন' : 'নতুন প্রোডাক্ট যোগ করুন' }}</h3>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="name">প্রোডাক্টের নাম</label>
        <input type="text" id="name" v-model="form.name" required>
      </div>
      <div class="form-group">
        <label for="description">বিবরণ</label>
        <textarea id="description" v-model="form.description" required></textarea>
      </div>
      <div class="form-group">
        <label for="price">মূল্য</label>
        <input type="number" id="price" v-model="form.price" required min="0">
      </div>
      <div class="form-group">
        <label for="stock">স্টক</label>
        <input type="number" id="stock" v-model="form.stock" required min="0">
      </div>
      <button type="submit" class="submit-button">{{ isEditing ? 'আপডেট করুন' : 'যোগ করুন' }}</button>
      <button type="button" @click="$emit('cancel')" class="cancel-button">বাতিল করুন</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    editingProduct: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      form: {
        name: '',
        description: '',
        price: 0,
        stock: 0,
      },
    };
  },
  computed: {
    isEditing() {
      return this.editingProduct !== null;
    },
  },
  watch: {
    editingProduct: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          // যখন এডিটিং মোডে যাবে, ফর্মের ডেটা পূরণ করবে
          this.form = { ...newVal };
        } else {
          // যখন এডিটিং মোড থেকে বের হবে, ফর্ম খালি করে দেবে
          this.resetForm();
        }
      },
    },
  },
  methods: {
    async submitForm() {
      try {
        const token = localStorage.getItem('authToken');
        const headers = {
          'Authorization': `Bearer ${token}`
        };

        if (this.isEditing) {
          // প্রোডাক্ট আপডেট করার জন্য PUT রিকোয়েস্ট
          await axios.put(`http://localhost:8000/api/products/${this.editingProduct.id}`, this.form, { headers });
          alert('প্রোডাক্ট সফলভাবে আপডেট করা হয়েছে!');
        } else {
          // নতুন প্রোডাক্ট যোগ করার জন্য POST রিকোয়েস্ট
          await axios.post('http://localhost:8000/api/products', this.form, { headers });
          alert('প্রোডাক্ট সফলভাবে যোগ করা হয়েছে!');
          this.resetForm();
        }
        
        this.$emit('product-saved'); // সফল হলে ড্যাশবোর্ডকে জানায়
      } catch (error) {
        alert(`প্রোডাক্ট ${this.isEditing ? 'আপডেট' : 'যোগ'} করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।`);
        console.error('Product form submit error:', error);
      }
    },
    resetForm() {
      this.form = {
        name: '',
        description: '',
        price: 0,
        stock: 0,
      };
    },
  },
};