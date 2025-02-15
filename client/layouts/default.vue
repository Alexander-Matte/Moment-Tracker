<template>
  <div class="min-h-screen flex flex-col">
    <Header
      :isLightMode="isLightMode"
      :navTabItems="navTabItems"
      @tabChange="onTabChange"
      @lightModeUpdate="onLightModeUpdate"
    />
    <main class="flex-1 flex justify-center items-center px-6">
      <div class="max-w-2xl w-full px-8 py-6">
        <slot />
      </div>
    </main>
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { useSettingsStore } from '@/stores/useSettingsStore'
const settingsStore = useSettingsStore()

const isLightMode = ref(settingsStore.isLightMode)
const selected = ref(0)
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

// Handle tab change
function onTabChange(index: number) {
  selected.value = index
}

onMounted(() => {
  if (settingsStore.isLightMode) {
    // Remove 'dark' class to ensure light mode is applied by default
    document.documentElement.classList.remove('dark')
  } else {
    // Add 'dark' class if dark mode is active
    document.documentElement.classList.add('dark')
  }
})

function onLightModeUpdate(value: boolean) {
  settingsStore.setLightMode(value)

  // Toggle the 'dark' class based on user preference
  if (value) {
    document.documentElement.classList.remove('dark')
  } else {
    document.documentElement.classList.add('dark')
  }
}
</script>
