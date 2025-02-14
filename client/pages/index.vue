<template>
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="py-6 px-10 border-b">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Moment Tracker</h1>
        
        <aside>
          <UTabs :items="SIDEBARITEMS" />
        </aside>

        <button @click="toggleDarkMode" class="text-link hover:underline">
          Toggle Theme
        </button>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex justify-center items-center px-6">
      <div class="max-w-2xl w-full px-8 py-6">
        <h2 class="text-xl font-semibold text-accent mb-4">
          Welcome to Moment Tracker
        </h2>
        <p class="text-lg">
          Track and manage your moments efficiently with our intuitive platform.
        </p>
      </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 px-10 border-t">
      <p class="text-center text-sm text-gray-500">
        &copy; 2025 Moment Tracker. All rights reserved.
      </p>
    </footer>
  </div>
</template>


<script setup lang="ts">

const isDarkMode = ref(false)

const SIDEBARITEMS = [{
  label: 'My Moments',
  icon: 'i-heroicons-heart-16-solid',
}, {
  label: 'Create and Manage Moments',
  icon: 'i-heroicons-pencil-square-16-solid',
}, {
  label: 'Statistics',
  icon: 'i-heroicons-presentation-chart-bar-solid',
}]

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}
</script>

<style scoped>

</style>
