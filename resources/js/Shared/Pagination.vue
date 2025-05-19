<template>
    <div class="flex space-x-1 justify-center">
      <template v-for="(link, i) in links" :key="i">
        <span
          v-if="!link.url"
          class="px-3 py-1 text-gray-400 border rounded"
          v-html="link.label"
        />
        <Link
          v-else
          :href="link.url"
          class="px-3 py-1 border rounded"
          :class="{
            'bg-blue-500 text-white': link.active,
            'hover:bg-gray-100': !link.active
          }"
          v-html="link.label"
        />
      </template>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3'
  
  defineProps({
    links: Array,
  })
  </script>
  