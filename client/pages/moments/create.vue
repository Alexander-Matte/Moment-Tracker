<script setup lang="ts">
import { z } from 'zod';
import type { FormSubmitEvent } from '#ui/types';
import { momentSchema } from '@/src/interfaces/schemas/momentSchema';
import { sub, format, isSameDay, type Duration } from 'date-fns'

const countryStore = useCountryStore();
const date = ref(new Date())
const rangeSelected = ref({ start: sub(new Date(), { days: 14 }), end: new Date() })
const selectedDateTab= ref(0)

type Schema = z.output<typeof momentSchema>;

const formData = reactive<Schema>({
  title: '',
  description: '',
  date_from: undefined,
  date_to: undefined,
  exact_date: undefined,
  region: '', 
  country_id: [],
  submoments: []
});

const ranges = [
  { label: 'Last 7 days', duration: { days: 7 } },
  { label: 'Last 14 days', duration: { days: 14 } },
  { label: 'Last 30 days', duration: { days: 30 } },
  { label: 'Last 3 months', duration: { months: 3 } },
  { label: 'Last 6 months', duration: { months: 6 } },
  { label: 'Last year', duration: { years: 1 } }
]

const dateSelectorItems = [
  {
    label: 'Date Range',
    icon: 'i-heroicons-calendar-days'
  },
  {
    label: 'Exact Date',
    icon: 'i-heroicons-calendar'
  }
]

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

watch(rangeSelected, (newValue) => {
  formData.date_from = newValue.start;
  formData.date_to = newValue.end;
}, { deep: true });


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

function isRangeSelected(duration: Duration) {
  return isSameDay(rangeSelected.value.start, sub(new Date(), duration)) && isSameDay(rangeSelected.value.end, new Date())
}

function selectRange(duration: Duration) {
  rangeSelected.value = { start: sub(new Date(), duration), end: new Date() }
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

      <UTabs v-model="selectedDateTab" :items="dateSelectorItems" />

      <div v-if="selectedDateTab === 0" class="mt-4">
        <UFormGroup label="When did this moment occure? (To-From)" name="date_from">
          <UPopover :popper="{ placement: 'bottom-start' }">
            <UButton icon="i-heroicons-calendar-days-20-solid">
              {{ format(rangeSelected.start, 'd MMM, yyy') }} - {{ format(rangeSelected.end, 'd MMM, yyy') }}
            </UButton>

            <template #panel="{ close }">
              <div class="flex items-center sm:divide-x divide-gray-200 dark:divide-gray-800">
                <div class="hidden sm:flex flex-col py-4">
                  <UButton
                    v-for="(range, index) in ranges"
                    :key="index"
                    :label="range.label"
                    color="gray"
                    variant="ghost"
                    class="rounded-none px-6"
                    :class="[isRangeSelected(range.duration) ? 'bg-gray-100 dark:bg-gray-800' : 'hover:bg-gray-50 dark:hover:bg-gray-800/50']"
                    truncate
                    @click="selectRange(range.duration)"
                  />
                </div>

                <DatePicker v-model="rangeSelected" @close="close" />
              </div>
            </template>
          </UPopover>
        </UFormGroup>
      </div>

      <div v-else class="mt-4">
        <UFormGroup label="Exact Date" name="exact_date">
          <UPopover :popper="{ placement: 'bottom-start' }">
            <UButton icon="i-heroicons-calendar-days-20-solid" :label="format(date, 'd MMM, yyy')" />
            <template #panel="{ close }">
              <DatePicker v-model="formData.exact_date" is-required @close="close" />
            </template>
          </UPopover>
        </UFormGroup>
      </div>



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
