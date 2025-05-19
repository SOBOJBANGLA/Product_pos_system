<template>
  <div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Order #{{ order.id }}</h1>
        <div class="space-x-4">
          <a
            :href="route('invoice.download', order.id)"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
          >
            Download Invoice
          </a>
          <Link
            :href="route('orders.index')"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
          >
            Back to Orders
          </Link>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
          <h2 class="text-lg font-semibold mb-2">Order Details</h2>
          <p><strong>Date:</strong> {{ formatDate(order.created_at) }}</p>
          <p><strong>Status:</strong> 
            <span :class="{
              'text-green-600': order.status === 'paid',
              'text-yellow-600': order.status === 'pending',
              'text-red-600': order.status === 'cancelled'
            }">
              {{ order.status }}
            </span>
          </p>
          <p><strong>Post Code:</strong> {{ order.post_code || 'N/A' }}</p>
        </div>
        <div>
          <h2 class="text-lg font-semibold mb-2">Payment Summary</h2>
          <p><strong>Subtotal:</strong> ৳{{ order.subtotal }}</p>
          <p><strong>Discount:</strong> ৳{{ order.discount }}</p>
          <p><strong>Tax:</strong> ৳{{ order.tax }}</p>
          <p class="text-xl font-bold"><strong>Total:</strong> ৳{{ order.total }}</p>
        </div>
      </div>

      <div class="mb-6">
        <h2 class="text-lg font-semibold mb-4">Order Items</h2>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in order.items" :key="item.id">
              <td class="px-6 py-4 whitespace-nowrap">
                {{ item.product.name }}
                <div v-if="item.variation" class="text-sm text-gray-500">
                  {{ item.variation.attribute }}: {{ item.variation.value }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ item.quantity }}</td>
              <td class="px-6 py-4 whitespace-nowrap">৳{{ item.price }}</td>
              <td class="px-6 py-4 whitespace-nowrap">৳{{ (item.price * item.quantity).toFixed(2) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  order: Object
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>
  