<template>
  <header class="py-6 px-2 border-b">
    <div class="container mx-auto flex items-center">
      <!-- Left: Title -->
      <h1 class="text-2xl font-bold">Moment Tracker</h1>

      <!-- Middle: Tabs -->
      <div class="flex-1 flex justify-center">
        <UTabs :items="navTabItems" :model-value="selectedTab" @update:model-value="onTabChange" />
      </div>

      <!-- Darkmode Toggle -->
      <i :class="isLightMode ? 'i-heroicons-sun-20-solid' : 'i-heroicons-moon-20-solid'"></i>

      <UToggle
        v-model="selectedTheme"
        size="2xl"
        on-icon="i-heroicons-sun-20-solid"
        off-icon="i-heroicons-moon-20-solid"
        @change="onLightModeUpdate"
      />

      <i :class="isLightMode ? 'i-heroicons-sun-20-solid' : 'i-heroicons-moon-20-solid'"></i>
    </div>
  </header>
</template>

<script setup lang="ts">
const props = defineProps<{
  isLightMode: boolean
  navTabItems: { label: string }[]
  selectedTab: number
}>()


const emit = defineEmits<{
  tabChange: [id: number]
  lightModeUpdate: [value: boolean]
}>()


const selectedTheme = ref(props.isLightMode)

// Emit tab change event with the tab index
function onTabChange(index: number) {
  emit('tabChange', index)
}

// Emit dark mode toggle event with the new dark mode value
function onLightModeUpdate(value: boolean) {
  emit('lightModeUpdate', value)
}
</script>
