<script setup lang="ts">
import { z } from 'zod';
import type { FormSubmitEvent } from '#ui/types';
import { momentSchema } from '@/src/interfaces/schemas/momentSchema';
import { sub, format, isSameDay, type Duration } from 'date-fns'

const countryStore = useCountryStore();
const date = ref(new Date())
const rangeSelected = ref({ start: sub(new Date(), { days: 14 }), end: new Date() });
const route = useRoute()
const router = useRouter()

type Schema = z.output<typeof momentSchema>;

const formData = reactive<Schema>({
  title: '',
  description: '',
  date_from: rangeSelected.value.start,
  date_to: rangeSelected.value.end,
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
    key: 'date-exact',
    label: 'Exact Date',
    icon: 'i-heroicons-calendar'
  },
  {
    key: 'date-range',
    label: 'Date Range',
    icon: 'i-heroicons-calendar-days'
  },

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


function isRangeSelected(duration: Duration) {
  return isSameDay(rangeSelected.value.start, sub(new Date(), duration)) && isSameDay(rangeSelected.value.end, new Date());
}

function selectRange(duration: Duration) {
  rangeSelected.value = { start: sub(new Date(), duration), end: new Date() }
}



const regions = computed(() => {
  const regionSet = new Set<string>();
  countryStore.countries.forEach(country => {
    if (country.region) {
      regionSet.add(country.region);
    }
  });

  return Array.from(regionSet).map(region => ({
    label: region,
    value: region
  }));
});

function handleRegionChange(selectedRegion: { value: string | undefined; }) {
  formData.region = selectedRegion ? selectedRegion.value : '';
}

const filteredCountryOptions = computed(() => {
  if (!formData.region) return [];
  return countryStore.countries
    .filter(country => country.region === formData.region)
    .map(country => ({
      label: country.name,
      value: country["@id"],
    }));
});

async function onSubmit(event: FormSubmitEvent<Schema>) {
  // Ensure only one type of date selection is allowed
  const hasExactDate = !!formData.exact_date;
  const hasDateRange = !!formData.date_from || !!formData.date_to;

  if (hasExactDate && hasDateRange) {
    console.warn("You must select either an exact date or a date range, but not both.");
    return;
  }

  const formatDate = (date: Date | undefined) => date ? format(date, 'dd-MM-yyyy') : undefined;

  const formattedData = {
    ...formData,
    date_from: formatDate(formData.date_from) || (hasDateRange ? formatDate(rangeSelected.value.start) : undefined),
    date_to: formatDate(formData.date_to) || (hasDateRange ? formatDate(rangeSelected.value.end) : undefined),
    exact_date: formatDate(formData.exact_date),
  };

  console.log(formattedData);
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

      <UTabs :items="dateSelectorItems" class="w-full">
        <template #item="{ item }">
          <UCard @submit.prevent>
            <template #header>
              <p class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
                {{ item.label }}
              </p>
            </template>

            <div v-if="item.key === 'date-range'" class="space-y-3">
              <UPopover :popper="{ placement: 'bottom-start' }">
                <UButton icon="i-heroicons-calendar-days-20-solid">
                  {{ format(rangeSelected.start, 'd MMM, yyyy') }} - {{ format(rangeSelected.end, 'd MMM, yyyy') }}
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
            </div>

            <div v-else-if="item.key === 'date-exact'" class="space-y-3">
              <UPopover :popper="{ placement: 'bottom-start' }">
                <UButton icon="i-heroicons-calendar-days-20-solid" :label="format(date, 'd MMM, yyyy')" />

                <template #panel="{ close }">
                  <DatePicker v-model="date" is-required @close="close" />
                </template>
              </UPopover>
            </div>
          </UCard>
        </template>
      </UTabs>

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

