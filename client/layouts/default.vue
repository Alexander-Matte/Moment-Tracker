<template>
  <div class="min-h-screen flex flex-col">
    <Header
      :isLightMode="isLightMode"
      :navLinks="navLinks"
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
const settingsStore = useSettingsStore()
const router = useRouter()
const route = useRoute()
const isLightMode = ref(settingsStore.isLightMode)

const navLinks = [
  { label: 'Home', icon: 'i-heroicons-home', to: '/' },
  { label: 'Moment Manager', icon: 'i-heroicons-pencil-square', to: '/moments' },
  { label: 'Statistics', icon: 'i-heroicons-chart-bar', to: '/statistics' }
]

const selectedTab = computed({
  get() {
    const index = navLinks.findIndex(item => item.to === route.path)
    return index !== -1 ? index : 0
  },
  set(value) {
    router.replace({ path: navLinks[value].to })
  }
})

function onLightModeUpdate(value: boolean) {
  settingsStore.setLightMode(value)
  document.documentElement.classList.toggle('dark', !value)
}

// Check and apply theme on mount using store
onMounted(() => {
  isLightMode.value = settingsStore.isLightMode
  document.documentElement.classList.toggle('dark', !isLightMode.value)
})
</script>