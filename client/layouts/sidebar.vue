<!-- layouts/sidebar.vue -->
<template>
    <div :class="{ 'dark': isDarkMode }">
      <Header
        :isDarkMode="isDarkMode"
        :selected="selected"
        :navTabItems="navTabItems"
        @update:selected="selected = $event"
        @update:isDarkMode="isDarkMode = $event"
      />
      <main class="flex-1 flex">
        <div v-if="selected === 1" class="w-1/4 bg-gray-100 p-6 border-r">
          <h3 class="text-xl font-semibold mb-4">Manage Moments</h3>
          <ul>
            <li><router-link to="/moments/dashboard" class="block p-2 hover:bg-gray-200">List Moments</router-link></li>
            <li><router-link to="/moments/add" class="block p-2 hover:bg-gray-200">Add Moment</router-link></li>
          </ul>
        </div>
        <div class="flex-1 px-8 py-6">
          <slot />
        </div>
      </main>
      <Footer />
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue'
  import Header from '../components/Header.vue'
  import Footer from '../components/Footer.vue'
  
  const isDarkMode = ref(false)
  const selected = ref(1)
  const navTabItems = [{
    label: 'Home',
    icon: 'i-heroicons-home-20-solid',
  }, {
    label: 'Moment Manager',
    icon: 'i-heroicons-pencil-square-16-solid',
  }, {
    label: 'Statistics',
    icon: 'i-heroicons-presentation-chart-bar-solid',
  }]
  </script>
  