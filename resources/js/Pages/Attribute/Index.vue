<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { throttle } from 'lodash';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import VueFeather from 'vue-feather';

const props = defineProps({
  attributes: Object,
  filters: {
    search: String,
    rows: Number,
  },
});
const search = ref(props.filters.search);
const rows = ref(props.filters.rows);
const hasSuccess = ref(usePage().props.value.flash.success);
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
            <vue-feather type="check-circle"></vue-feather>
            <span>{{ hasSuccess }}</span>
          </div>
          <div class="flex-none">
            <button class="btn btn-sm btn-circle btn-ghost" @click.prevent="hasSuccess = null">
              <vue-feather type="x"></vue-feather>
            </button>
          </div>
        </div>
        <!-- End success alert -->

        <div class="flex justify-between mb-3">
          <Link :href="route('attributes.create')" class="btn btn-primary gap-1">
          <vue-feather type="plus-circle"></vue-feather>
          <span>Create Property</span>
          </Link>

          <div class="flex gap-2">
            <select class="select select-bordered w-full max-w-fit" v-model="rows" @change="setRows(rows)">
              <option value="10">10</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <input v-model="search" type="text" class="input input-bordered w-80 justify-end hidden sm:block"
              placeholder="Search product property..." />
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card card-compact rounded-none">
              <div class="card-title justify-end px-8 py-1"></div>
              <div class="card-body">
                <div class="overflow-x-auto">
                  <table class="table table-compact table-zebra w-full shadow">
                    <!-- head -->
                    <thead>
                      <tr>
                        <th class="w-[7%]">#</th>
                        <th>Name</th>
                        <th>Language</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(attribute, index) in attributes.data" :key="attribute.id" class="hover">
                        <td>
                          <Link class="flex items-center py-2 btn-link text-neutral"
                            :href="`/attributes/${attribute.id}/edit`">
                          {{ index + 1 }}
                          </Link>
                        </td>
                        <td>
                          <Link class="btn-link flex text-neutral items-center py-2"
                            :href="`/attributes/${attribute.id}/edit`">
                          {{ attribute.name }}
                          </Link>
                        </td>
                        <td>
                          <Link class="btn-link flex text-neutral items-center py-2"
                                :href="`/attributes/${attribute.id}/edit`">
                            {{ attribute.language }}
                          </Link>
                        </td>
                      </tr>
                      <tr v-if="attributes.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="2">
                          No properties found.
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div>
                  <Pagination class="mt-4" :links="attributes.links" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
