<script setup lang="ts">
import { z } from 'zod';
import type { FormSubmitEvent } from '#ui/types';
import { momentSchema } from '@/src/interfaces/schemas/momentSchema';

const countryStore = useCountryStore();

type Schema = z.output<typeof momentSchema>;

const formData = reactive<Schema>({
  title: '',
  description: '',
  date_from: undefined,
  date_to: undefined,
  exact_date: undefined,
  region: '',  // Selected region
  country_id: [],  // Array of selected countries
  submoments: []
});

// Fetch countries on mount if they are not already fetched
onMounted(async () => {
  if (countryStore.countries.length === 0) {
    await countryStore.fetchCountries();
  }
});

// Watch for changes in the region selection to filter countries
watch(() => formData.region, () => {
  // Reset selected countries when region changes
  formData.country_id = [];
});

// Get unique regions from countries
const regions = computed(() => {
  const regionSet = new Set<string>(); 

  countryStore.countries.forEach(country => {
    if (country.region) {
      regionSet.add(country.region);
    }
  });

  return Array.from(regionSet).map(region => ({
    label: region, // Display the region name as label
    value: region   // Use the region name as value
  }));
});

// Handle the region change to make sure only the value (region name) is set
function handleRegionChange(selectedRegion: { value: string | undefined; }) {
  formData.region = selectedRegion ? selectedRegion.value : '';
}


// Filter countries based on the selected region
const filteredCountryOptions = computed(() => {
  if (!formData.region) return [];  // No region selected, show no countries
  return countryStore.countries
    .filter(country => country.region === formData.region)
    .map(country => ({
      label: country.name,  // Display name of the country
      value: country["@id"],  // Use country id for selection
    }));
});



async function onSubmit(event: FormSubmitEvent<Schema>) {
  // Handle form submission
  console.log(event.data);
}
</script>

<template>
  <div class="py-6">
    <UForm :schema="momentSchema" :state="formData" class="space-y-4" @submit="onSubmit">
      <UFormGroup label="Title" name="title">
        <UInput v-model="formData.title" />
      </UFormGroup>

      <UFormGroup label="Description" name="description">
        <UTextarea v-model="formData.description" />
      </UFormGroup>

      <UFormGroup label="Start Date" name="date_from">
        <UInput v-model="formData.date_from" type="date" />
      </UFormGroup>

      <UFormGroup label="End Date" name="date_to">
        <UInput v-model="formData.date_to" type="date" />
      </UFormGroup>

      <UFormGroup label="Exact Date" name="exact_date">
        <UInput v-model="formData.exact_date" type="date" />
      </UFormGroup>

      <!-- Region Dropdown -->
      <UFormGroup label="Region" name="region">
        <USelectMenu
            v-model="formData.region" 
            :options="regions"
            class="w-full lg:w-48"
            placeholder="Select a region"
            @change="handleRegionChange"
        />
      </UFormGroup>




      <!-- Countries Dropdown -->
      <UFormGroup label="Countries" name="country_id">
        <USelectMenu
          v-model="formData.country_id"
          :options="filteredCountryOptions"
          multiple
          searchable
          searchable-placeholder="Search a country..."
          class="w-full lg:w-48"
          placeholder="Select countries"
        />
      </UFormGroup>

      <UFormGroup label="Submoments" name="submoments">
        <USelectMenu v-model="formData.submoments" :options="['Moment1', 'Moment2']" multiple />
      </UFormGroup>

      <UButton type="submit">Create Moment</UButton>
    </UForm>
  </div>
</template>
