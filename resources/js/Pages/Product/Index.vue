<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { throttle } from 'lodash';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import VueFeather from 'vue-feather';

const props = defineProps({
  products: Object,
  filters: {
    search: String,
    rows: Number,
  },
});
const search = ref(props.filters.search);
const rows = ref(props.filters.rows);
const hasSuccess = ref(usePage().props.value.flash.success);
const setRows = (rows) => {
  Inertia.get('/products', { rows: rows }, { preserveState: true, replace: true });
};

watch(
  search,
  throttle(function (value) {
    Inertia.get('/products', { search: value }, { preserveState: true, replace: true });
  }, 500)
);
</script>

<template>

  <Head title="Product" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Products
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
          <Link :href="route('products.create')" class="btn btn-primary flex gap-2">
          <vue-feather type="plus-circle"></vue-feather>
          <span>Create Product</span>
          </Link>

          <div class="flex gap-2">
            <select class="select select-bordered w-full max-w-fit" v-model="rows" @change="setRows(rows)">
              <option value="10">10</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <input v-model="search" type="text" class="input input-bordered w-80 justify-end hidden sm:block"
              placeholder="Search product..." />
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
                        <th width="10%">#</th>
                        <th width="40%" align="center">Name</th>
                        <th width="20%" align="center">Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(product, index) in products.data" :key="product.id" class="hover">
                        <td align="center">
                          <Link class="flex items-center py-2 btn-link text-neutral"
                            :href="`/products/${product.id}/edit`">
                          {{ index + 1 }}.
                          </Link>
                        </td>
                        <td>
                          <Link class="btn-link flex text-neutral items-center py-2"
                            :href="`/products/${product.id}/edit`">
                          <span>{{ product.name }}</span>
                          </Link>
                        </td>
                        <td align="center">
                          <div class="badge flex gap-1 py-3"
                            :class="{ 'badge-success': product.is_active, 'badge-error': !product.is_active }">
                            <vue-feather type="check-circle" size="14" stroke="white" stroke-width="2"></vue-feather>
                            <span class="font-bold text-white">
                              {{ product.is_active ? 'Active' : 'Inactive' }}
                            </span>
                          </div>
                        </td>
                        <td>
                          <Link class="flex gap-2 btn btn-link" :href="`/products/${product.id}/summary`">
                          <vue-feather type="link" size="14"></vue-feather>
                          Summary
                          </Link>
                        </td>
                      </tr>
                      <tr v-if="products.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="2">
                          No properties found.
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div>
                  <Pagination class="mt-4" :links="products.links" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
