export const useSettingsStore = defineStore('settings', () => {
    const lightMode = ref(true)
  
    function setLightMode(value: boolean) {
      lightMode.value = value
    }
  
    const isLightMode = computed(() => lightMode.value)
  
    return { lightMode, setLightMode, isLightMode }
  }, {
    persist: true, // This enables persistence for this store
  })
  