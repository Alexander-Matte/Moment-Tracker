export const useSettingsStore = defineStore('settings', () => {
    const lightMode = ref(true)

  
    function setLightMode(value: boolean) {
      lightMode.value = value
    }

    const isLightMode = computed(() => lightMode.value)

  
    return { setLightMode, isLightMode, lightMode}
  }, {
    persist: true,
  })
  