import type { Country } from '@/src/interfaces/generated/country'

export const useCountryStore = defineStore('countries', () => {
  const countries = reactive<Country[]>([])


  async function fetchCountries() {
    try {
      const response = await $fetch<{ member: Country[] }>('http://localhost:8033/api/countries')

      if (response && response.member) {
        countries.splice(0, countries.length, ...response.member)
      }
    } catch (error) {
      console.error('Error fetching countries:', error)
    }
  }

  return { countries, fetchCountries }
})
