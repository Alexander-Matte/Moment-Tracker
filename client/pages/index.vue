<template>
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="py-6 px-2 border-b">
      <div class="container mx-auto flex items-center">
        <!-- Left: Title -->
        <h1 class="text-2xl font-bold">Moment Tracker</h1>

        <!-- Middle: Tabs -->
        <div class="flex-1 flex justify-center">
          <UTabs v-model="selected" :items="navTabItems" class="max-w-xl w-full" />
        </div>

        <!-- Right: Toggle Button -->
        <button @click="toggleDarkMode" class="text-link hover:underline text-right">
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

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}

const route = useRoute()
const router = useRouter()

const selected = computed({
  get() {
    const index = navTabItems.findIndex(item => item.label === route.query.tab)
    if (index === -1) {
      return 0
    }

    return index
  },
  set(value) {
    // Hash is specified here to prevent the page from scrolling to the top
    router.replace({ query: { tab: navTabItems[value].label }})
  }
})
</script>

<style scoped>

</style>
