<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { throttle } from 'lodash';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
  attributes: Object,
  filters: {
    search: String,
    rows: Number,
  },
});
const search = ref(props.filters.search);
const rows = ref(props.filters.rows);
const hasSuccess = usePage().props.value.flash.success;
const setRows = (rows) => {
  Inertia.get('/attributes', { rows: rows }, { preserveState: true, replace: true });
};

watch(
  search,
  throttle(function (value) {
    Inertia.get('/attributes', { search: value }, { preserveState: true, replace: true });
  }, 500)
);
</script>

<template>
  <Head title="Product" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Product Properties
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- On success alert -->
        <div v-if="hasSuccess" class="alert alert-success shadow-lg mb-3">
          <div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="stroke-current flex-shrink-0 h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            <span>{{ hasSuccess }}</span>
          </div>
          <div class="flex-none">
            <button
              class="btn btn-sm btn-circle btn-ghost text-neutral"
              @click.prevent="hasSuccess = null"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
        <!-- End success alert -->

        <div class="flex justify-between mb-3">
          <Link :href="route('attributes.create')" class="btn btn-accent text-white">
            Create Property
          </Link>

          <div class="flex gap-2">
            <select
              class="select select-bordered w-full max-w-fit"
              v-model="rows"
              @change="setRows(rows)"
            >
              <option value="10">10</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <input
              v-model="search"
              type="text"
              class="input input-bordered w-80 justify-end hidden sm:block"
              placeholder="Search product property..."
            />
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card rounded-none">
              <div class="card-title justify-end px-8 py-1"></div>
              <div class="card-body">
                <div class="overflow-x-auto">
                  <table class="table table-zebra w-full shadow">
                    <!-- head -->
                    <thead>
                      <tr>
                        <th width="15%">#</th>
                        <th>Name</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="attribute in attributes.data"
                        :key="attribute.id"
                        class="hover"
                      >
                        <td>
                          {{ attribute.id }}
                        </td>
                        <td>
                          {{ attribute.name }}
                        </td>
                        <th>
                          <Link
                            class="btn btn-xs btn-ghost"
                            :href="`/attributes/${attribute.id}/edit`"
                            >Edit</Link
                          >
                        </th>
                      </tr>
                    </tbody>
                  </table>
                  <div>
                    <Pagination class="mt-4" :links="attributes.links" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>