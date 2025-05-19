<template>
    <div>
      <div class="flex gap-4 mb-4">
        <input type="date" v-model="startDate" class="border px-2 py-1 rounded" />
        <input type="date" v-model="endDate" class="border px-2 py-1 rounded" />
        <button @click="filterOrders" class="px-4 py-2 bg-blue-500 text-white rounded">
          Filter
        </button>
      </div>
  
      <table class="w-full text-left border">
        <thead>
          <tr>
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Total</th>
            <th class="p-2 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders.data" :key="order.id" class="border-t">
            <td class="p-2">{{ order.created_at }}</td>
            <td class="p-2">{{ order.total }} Tk</td>
            <td class="p-2">
              <Link :href="route('orders.show', order.id)" class="text-blue-500 hover:underline">
                View
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
  
      <Pagination :links="orders.links" class="mt-4" />
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { Link, router } from '@inertiajs/vue3'
  
  const props = defineProps({ orders: Object })
  
  const startDate = ref('')
  const endDate = ref('')
  
  const filterOrders = () => {
    router.get(route('orders.index'), {
      start_date: startDate.value,
      end_date: endDate.value
    }, {
      preserveState: true,
      replace: true
    })
  }
  </script>
  