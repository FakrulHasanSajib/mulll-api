// src/components/Cart.vue

<template>
  <div class="cart-container">
    <h2 class="title">আমার কার্ট</h2>
    <div v-if="cartItems.length === 0">
      <p>আপনার কার্ট খালি।</p>
    </div>
    <div v-else>
      <div v-for="item in cartItems" :key="item.product.id" class="cart-item">
        <div class="item-info">
          <h4>{{ item.product.name }}</h4>
          <p>মূল্য: {{ item.product.price }} টাকা</p>
        </div>
        <div class="item-controls">
          <input type="number" v-model="item.quantity" min="1" @change="updateQuantity(item)">
          <button @click="removeItem(item.product.id)">সরিয়ে ফেলুন</button>
        </div>
      </div>
      <div class="cart-summary">
        <h4>মোট: {{ totalAmount }} টাকা</h4>
        <button class="checkout-btn">চেকআউট করুন</button>
      </div>
    </div>
    <button @click="$emit('back')">প্রোডাক্ট লিস্টে ফিরে যান</button>
  </div>
</template>

<script>
export default {
  props: ['cartItems'],
  emits: ['update-quantity', 'remove-item', 'back'],
  computed: {
    totalAmount() {
      return this.cartItems.reduce((total, item) => total + item.product.price * item.quantity, 0);
    }
  },
  methods: {
    updateQuantity(item) {
      this.$emit('update-quantity', item);
    },
    removeItem(productId) {
      this.$emit('remove-item', productId);
    },
  },
};
</script>

<style scoped>

</style>