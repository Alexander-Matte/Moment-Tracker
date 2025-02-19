<template>
  <header class="py-6 px-2 border-b">
    <div class="container mx-auto flex items-center justify-between gap-4">
      <h1 class="text-2xl font-bold whitespace-nowrap flex-shrink-0">Moment Tracker</h1>
      <UHorizontalNavigation :links="navLinks" class="border-b border-gray-200 dark:border-gray-800 flex justify-center flex-grow" />
      <div class="flex-shrink-0">
        <UToggle
          v-model="selectedTheme"
          size="2xl"
          on-icon="i-heroicons-sun-20-solid"
          off-icon="i-heroicons-moon-20-solid"
          @change="onLightModeUpdate"
        />
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
const props = defineProps<{
  isLightMode: boolean
  navLinks: { label: string, to: string, icon: string }[]
}>()

const emit = defineEmits<{
  lightModeUpdate: [value: boolean]
}>()

const selectedTheme = ref(props.isLightMode)

function onLightModeUpdate(value: boolean) {
  emit('lightModeUpdate', value)
}
</script>