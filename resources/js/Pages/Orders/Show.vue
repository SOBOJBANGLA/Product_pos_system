<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Order #{{ order.id }}</h1>
      <p><strong>Date:</strong> {{ order.created_at }}</p>
      <p><strong>Total:</strong> {{ order.total }} Tk</p>
  
      <h2 class="text-xl font-semibold mt-4 mb-2">Items:</h2>
      <ul>
        <li v-for="item in order.items" :key="item.id">
          {{ item.product.name }} - Qty: {{ item.quantity }} - Price: {{ item.price }} Tk
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({ order: Object })
  </script>
  