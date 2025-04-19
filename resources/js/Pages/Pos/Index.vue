<template>
  <div class="flex h-screen">
    <!-- Product List Section -->
    <div class="w-2/3 p-4 bg-gray-100 overflow-y-auto">
      <div class="mb-4">
        <input
          v-model="search"
          placeholder="Search products..."
          class="w-full p-2 border rounded"
        />
      </div>

      <!-- Product Cards Grid -->
      <div v-if="products.data && products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="product in products.data"
          :key="product.id"
          class="bg-white shadow-md rounded-lg overflow-hidden"
        >
          <img
            :src="product.image ? '/storage/' + product.image : 'https://via.placeholder.com/300x200?text=No+Image'"
            alt="Product Image"
            class="w-full h-48 object-cover"
          />
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-1">{{ product.name }}</h3>
            <p class="text-sm text-gray-500 mb-2">SKU: {{ product.sku }}</p>

            <!-- Variation Dropdown -->
            <!-- <div v-if="product.variations.length" class="mb-2">
              <label class="block text-sm font-medium mb-1">Variation:</label>
              <select
                v-model="selectedVariations[product.id]"
                class="w-full p-2 border rounded"
              >
                <option
                  v-for="variation in product.variations"
                  :value="variation.id"
                  :key="variation.id"
                >
                  {{ variation.attribute }}: {{ variation.value }}
                </option>
              </select>
            </div> -->

            <!-- Price Section -->
            <div class="mb-2">
              <span v-if="product.discount > 0">
                <span class="line-through text-gray-400">{{ product.selling_price }} Tk</span>
                <span class="text-red-600 font-semibold ml-2">{{ calculateDiscount(product) }} Tk</span>
              </span>
              <span v-else class="text-green-600 font-semibold">{{ product.selling_price }} Tk</span>
            </div>

            <!-- Quantity and Add to Cart Button -->
            <div class="flex items-center">
              <input
                type="number"
                v-model.number="quantities[product.id]"
                min="1"
                class="w-16 p-2 border rounded mr-2"
              />
              <button
                @click="addToCart(product)"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
              >
                Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- No Products Found Message -->
      <div v-else class="text-center text-gray-500 mt-10">No products found.</div>

      <!-- Pagination -->
      <Pagination v-if="products.links" :links="products.links" class="mt-4" />
    </div>

    <!-- Shopping Cart Section -->
    <div class="w-1/3 p-4 bg-white border-l">
      <div class="sticky top-0">
        <h2 class="text-xl font-bold mb-4">Order Summary</h2>

        <div v-for="(item, index) in cart" :key="index" class="mb-1">
          {{ item.name }} x{{ item.quantity }}
          <span class="float-right">{{ item.total.toFixed(2) }} Tk</span>
        </div>

        <div class="mt-4 border-t pt-4">
          <div class="flex justify-between">
            <span>Subtotal:</span>
            <span>{{ subtotal.toFixed(2) }} Tk</span>
          </div>
          <div class="flex justify-between">
        <span>Discount:</span>
        <span class="text-red-600">-{{ discountTotal.toFixed(2) }} Tk</span>
      </div>
          <div class="flex justify-between">
            <span>Tax:</span>
            <span>{{ tax.toFixed(2) }} Tk</span>
          </div>
          <div class="flex justify-between font-bold">
            <span>Total:</span>
            <span>{{ total.toFixed(2) }} Tk</span>
          </div>
        </div>

        <!-- <input
          v-model="postCode"
          placeholder="Post Code"
          class="w-full p-2 border rounded mt-4"
        /> -->

        <button
          @click="placeOrder"
          class="w-full mt-4 px-4 py-2 bg-green-500 text-white rounded"
        >
          Place Order
        </button>
      </div>
    </div>
  </div>
</template>

<!-- <script setup>
import { ref, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import Pagination from '@/Shared/Pagination.vue' 

const props = defineProps({
  products: Object,
})

const search = ref('')
const cart = ref([])
const postCode = ref('')
const quantities = ref({})
const selectedVariations = ref({})

// Watch for search changes
watch(search, (val) => {
  router.get('/', { search: val }, { preserveState: true, replace: true })
})

// Add product to cart
const addToCart = (product) => {
  const quantity = quantities.value[product.id] || 1
  const price =
    product.discount > 0 ? parseFloat(calculateDiscount(product)) : product.selling_price
  const variation_id = selectedVariations.value[product.id] || null

  const existing = cart.value.find(
    (item) => item.id === product.id && item.variation_id === variation_id
  )

  if (existing) {
    existing.quantity += quantity
    existing.total = existing.quantity * price
  } else {
    cart.value.push({
      id: product.id,
      name: product.name,
      quantity,
      price,
      total: price * quantity,
      variation_id,
    })
  }

  quantities.value[product.id] = 1
}

// Discount calculator
const calculateDiscount = (product) => {
  const discountAmount = (product.selling_price * product.discount) / 100
  return (product.selling_price - discountAmount).toFixed(2)
}

// Totals
const subtotal = computed(() => cart.value.reduce((sum, item) => sum + item.total, 0))
const tax = computed(() => subtotal.value * 0.1)
const total = computed(() => subtotal.value + tax.value)

// Place order
const placeOrder = () => {
  if (!cart.value.length) {
    alert('Cart is empty!')
    return
  }

  router.post('/orders', {
    post_code: postCode.value,
    items: cart.value.map((item) => ({
      product_id: item.id,
      quantity: item.quantity,
      price: item.price,
      variation_id: item.variation_id,
    })),
    subtotal: subtotal.value,
    tax: tax.value,
    total: total.value,
  })
}
</script> -->

<script setup>
import { ref, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import Pagination from '@/Shared/Pagination.vue'

const props = defineProps({
  products: Object,
})

const search = ref('')
const cart = ref([])
const postCode = ref('')
const quantities = ref({})
const selectedVariations = ref({})

// Watch for search changes
watch(search, (val) => {
  router.get('/', { search: val }, { preserveState: true, replace: true })
})

// Add product to cart
const addToCart = (product) => {
  const quantity = quantities.value[product.id] || 1
  const price =
    product.discount > 0 ? parseFloat(calculateDiscount(product)) : product.selling_price
  const variation_id = selectedVariations.value[product.id] || null

  const existing = cart.value.find(
    (item) => item.id === product.id && item.variation_id === variation_id
  )

  if (existing) {
    existing.quantity += quantity
    existing.total = existing.quantity * price
  } else {
    cart.value.push({
      id: product.id,
      name: product.name,
      quantity,
      price,
      total: price * quantity,
      variation_id,
      selling_price: product.selling_price, // store original price for discount calculation
    })
  }

  quantities.value[product.id] = 1
}

// Discount calculator for a product
const calculateDiscount = (product) => {
  const discountAmount = (product.selling_price * product.discount) / 100
  return (product.selling_price - discountAmount).toFixed(2)
}

// Order Summary Calculations
const subtotal = computed(() => cart.value.reduce((sum, item) => sum + item.total, 0))

const discountTotal = computed(() =>
  cart.value.reduce((sum, item) => {
    const originalTotal = item.selling_price * item.quantity
    return sum + (originalTotal - item.total)
  }, 0)
)

const tax = computed(() => subtotal.value * 0.1)

const total = computed(() => subtotal.value + tax.value)

// Place order
const placeOrder = () => {
  if (!cart.value.length) {
    alert('Cart is empty!')
    return
  }

  router.post('/orders', {
    post_code: postCode.value,
    items: cart.value.map((item) => ({
      product_id: item.id,
      quantity: item.quantity,
      price: item.price,
      variation_id: item.variation_id,
    })),
    subtotal: subtotal.value,
    discount: discountTotal.value,
    tax: tax.value,
    total: total.value,
  })
}
</script>


<style scoped>
/* Add custom styles here if needed */
</style>