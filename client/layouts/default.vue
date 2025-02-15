<template>
  <div class="min-h-screen flex flex-col">
    <Header
      :isLightMode="isLightMode"
      :navTabItems="navTabItems"
      :selectedTab="selectedTab"
      @tabChange="onTabChange"
      @lightModeUpdate="onLightModeUpdate"
    />
    <main class="flex-1 flex justify-center items-center px-6">
      <div class="max-w-2xl w-full px-8 py-6">
        <NuxtPage />
      </div>
    </main>
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { useSettingsStore } from '@/stores/useSettingsStore'
import { useRouter, useRoute } from 'vue-router'

const settingsStore = useSettingsStore()
const router = useRouter()
const route = useRoute()
const isLightMode = ref(settingsStore.isLightMode)
const navTabItems = [
  { label: 'Home', icon: 'i-heroicons-home-20-solid', route: '/' },
  { label: 'Moment Manager', icon: 'i-heroicons-pencil-square-16-solid', route: '/moments' },
  { label: 'Statistics', icon: 'i-heroicons-presentation-chart-bar-solid', route: '/statistics' }
]

// Compute the selected tab based on the URL query
const selectedTab = computed({
  get() {
    const index = navTabItems.findIndex(item => item.route === route.path)
    return index !== -1 ? index : 0
  },
  set(value) {
    router.replace({ path: navTabItems[value].route, query: { tab: navTabItems[value].label } })
  }
})

// Handle tab change
function onTabChange(index: number) {
  selectedTab.value = index
}

// Dark mode toggle
function onLightModeUpdate(value: boolean) {
  settingsStore.setLightMode(value)
  document.documentElement.classList.toggle('dark', !value)
}
</script>
