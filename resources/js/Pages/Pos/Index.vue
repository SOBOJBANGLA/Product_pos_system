<template>
  <Suspense>
    <template #default>
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
                <div v-if="product.variations.length" class="mb-2">
                  <label class="block text-sm font-medium mb-1">Variation:</label>
                  <select
                    v-model="selectedVariations[product.id]"
                    class="w-full p-2 border rounded"
                  >
                    <option value="">Select Variation</option>
                    <option
                      v-for="variation in product.variations"
                      :value="variation.id"
                      :key="variation.id"
                    >
                      {{ variation.attribute }}: {{ variation.value }} - ৳{{ variation.selling_price }}
                    </option>
                  </select>
                </div>

                <!-- Price Section -->
                <div class="mb-2">
                  <template v-if="selectedVariations[product.id]">
                    <span v-if="product.discount > 0">
                      <span class="line-through text-gray-400">৳{{ getSelectedVariation(product).selling_price }}</span>
                      <span class="text-red-600 font-semibold ml-2">৳{{ getDisplayPrice(product) }}</span>
                    </span>
                    <span v-else class="text-green-600 font-semibold">৳{{ getDisplayPrice(product) }}</span>
                  </template>
                  <template v-else>
                    <span v-if="product.discount > 0">
                      <span class="line-through text-gray-400">৳{{ product.selling_price }}</span>
                      <span class="text-red-600 font-semibold ml-2">৳{{ getDisplayPrice(product) }}</span>
                    </span>
                    <span v-else class="text-green-600 font-semibold">৳{{ getDisplayPrice(product) }}</span>
                  </template>
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
                <span>Purchase Total:</span>
                <span>{{ purchaseTotal.toFixed(2) }} Tk</span>
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
              <div class="flex justify-between text-green-600 font-bold">
                <span>Profit:</span>
                <span>{{ profit.toFixed(2) }} Tk</span>
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
    <template #fallback>
      <div class="flex items-center justify-center h-screen">
        <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-gray-900"></div>
      </div>
    </template>
  </Suspense>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import Pagination from '@/Shared/Pagination.vue'
import { loadStripe } from '@stripe/stripe-js'

const stripe = ref(null)

onMounted(async () => {
  try {
    const stripeKey = 'pk_test_51QSW9lP7xz0DuK0bNhDkxvpVyucRtftWCssA6ePYeNqbEqtwPHaj2px1CY5GRfVFKCT9Bf3ikvNxtVNFZtVPo8xx00XyWw2b9I'
    if (!stripeKey) {
      console.error('Stripe key is not configured')
      return
    }
    stripe.value = await loadStripe(stripeKey)
    console.log('Stripe initialized successfully')
  } catch (error) {
    console.error('Error initializing Stripe:', error)
  }
})

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
  const selectedVariation = selectedVariations.value[product.id]
  
  let price, variation_id, variation_name, purchase_price, tax_rate, discount_rate
  
  if (selectedVariation) {
    const variation = product.variations.find(v => v.id === selectedVariation)
    price = variation.selling_price
    purchase_price = variation.purchase_price
    variation_id = variation.id
    variation_name = `${variation.attribute}: ${variation.value}`
    discount_rate = product.discount || 0 // ভ্যারিয়েশনের ক্ষেত্রেও মূল প্রোডাক্টের ডিসকাউন্ট ব্যবহার
  } else {
    price = product.selling_price
    purchase_price = product.purchase_price
    discount_rate = product.discount || 0
    variation_id = null
    variation_name = null
  }

  // ডিসকাউন্ট ক্যালকুলেশন
  const discountedPrice = discount_rate > 0 ? price - (price * discount_rate / 100) : price
  tax_rate = product.tax || 0

  const existing = cart.value.find(
    (item) => item.id === product.id && item.variation_id === variation_id
  )

  if (existing) {
    existing.quantity += quantity
    existing.price = discountedPrice
    existing.total = existing.quantity * discountedPrice
    existing.purchase_total = existing.quantity * purchase_price
    existing.tax_amount = (existing.total * tax_rate) / 100
    existing.discount_rate = discount_rate
    existing.discount_amount = (price * existing.quantity * discount_rate) / 100
  } else {
    cart.value.push({
      id: product.id,
      name: product.name,
      quantity,
      price: discountedPrice,
      total: discountedPrice * quantity,
      purchase_price,
      purchase_total: purchase_price * quantity,
      tax_rate,
      tax_amount: (discountedPrice * quantity * tax_rate) / 100,
      discount_rate,
      discount_amount: (price * quantity * discount_rate) / 100,
      variation_id,
      variation_name,
      selling_price: price,
    })
  }

  quantities.value[product.id] = 1
}

// Get selected variation
const getSelectedVariation = (product) => {
  const variationId = selectedVariations.value[product.id]
  if (!variationId) return product
  
  const variation = product.variations.find(v => v.id === variationId)
  if (!variation) return product
  
  return {
    ...variation,
    discount: product.discount, // মূল প্রোডাক্টের ডিসকাউন্ট ব্যবহার
    tax: product.tax // মূল প্রোডাক্টের ভ্যাট রেট ব্যবহার
  }
}

// Discount calculator for a product
const calculateDiscount = (product) => {
  const basePrice = selectedVariations.value[product.id] 
    ? product.variations.find(v => v.id === selectedVariations.value[product.id]).selling_price
    : product.selling_price
    
  const discountAmount = (basePrice * product.discount) / 100
  return (basePrice - discountAmount).toFixed(2)
}

// Price display with variation
const getDisplayPrice = (product) => {
  const basePrice = selectedVariations.value[product.id]
    ? product.variations.find(v => v.id === selectedVariations.value[product.id]).selling_price
    : product.selling_price

  const discountAmount = (basePrice * product.discount) / 100
  const discountedPrice = basePrice - discountAmount
  const taxAmount = (discountedPrice * product.tax) / 100
  return (discountedPrice + taxAmount).toFixed(2)
}

// Order Summary Calculations
const subtotal = computed(() => cart.value.reduce((sum, item) => sum + item.total, 0))

const purchaseTotal = computed(() => cart.value.reduce((sum, item) => sum + item.purchase_total, 0))

const discountTotal = computed(() => cart.value.reduce((sum, item) => sum + item.discount_amount, 0))

const tax = computed(() => cart.value.reduce((sum, item) => sum + item.tax_amount, 0))

const total = computed(() => subtotal.value + tax.value)

const profit = computed(() => subtotal.value - purchaseTotal.value)

// Place order with Stripe
const placeOrder = async () => {
  if (!cart.value.length) {
    alert('Cart is empty!')
    return
  }

  if (!stripe.value) {
    alert('Payment system is not initialized. Please try again.')
    return
  }

  try {
    const response = await fetch('/create-checkout-session', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
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
    })

    const data = await response.json()

    if (!response.ok) {
      throw new Error(data.error || 'Network response was not ok')
    }

    // Redirect to Stripe Checkout
    const result = await stripe.value.redirectToCheckout({
      sessionId: data.id
    })

    if (result.error) {
      alert(result.error.message)
    }
  } catch (error) {
    console.error('Error:', error)
    alert(error.message || 'An error occurred while processing your payment.')
  }
}
</script>

<style scoped>
/* Add custom styles here if needed */
</style>
