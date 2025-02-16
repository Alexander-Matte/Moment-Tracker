<template>
  <div :class="{ 'dark': !isLightMode }" class="min-h-screen flex flex-col bg-light-primary dark:bg-dark-primary text-black dark:text-white">
    <Header
      :isLightMode="isLightMode"
      :navLinks="navLinks"
      @lightModeUpdate="onLightModeUpdate"
    />
    <main class="flex px-6">
      <div class="flex" v-if="route.path.match('/moments')">
        <Sidebar />
      </div>
      <div class="flex flex-1 justify-center">
        <div class="max-w-2xl w-full mx-auto">
          <NuxtPage />
        </div>
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
  isLightMode.value = value
  document.documentElement.classList.toggle('dark', !value)
}

// Ensure theme is correctly applied on mount
onMounted(() => {
  isLightMode.value = settingsStore.isLightMode
  document.documentElement.classList.toggle('dark', !isLightMode.value)
})
</script>
