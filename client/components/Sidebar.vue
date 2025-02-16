<template>
    <aside class="w-64 h-screen p-4 bg-dark-secondary text-gray-300 shadow-lg border-r border-gray-700">
      <nav>
        <UVerticalNavigation :links="links" />
      </nav>
    </aside>
  </template>
  
  <script setup lang="ts">
  const links = [
  [{
    label: 'All Moments',
    icon: 'i-heroicons-list-bullet',
    to: '/moments'
  }, {
    label: 'Create Moment',
    icon: 'i-heroicons-plus-circle',
    to: '/moments/create'
  }, {
    label: 'Favorites',
    icon: 'i-heroicons-heart',
    to: '#'
  }, {
    label: 'Global View',
    icon: 'i-heroicons-globe-alt',
    to: '#'
  }], [{
    label: 'Examples',
    icon: 'i-heroicons-light-bulb',
    to: '#'  
}, {
    label: 'Help',
    icon: 'i-heroicons-question-mark-circle',
    to: '#'
  }]
]
  </script>
  