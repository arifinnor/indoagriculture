<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref, useAttrs, onMounted } from "vue";

const attrs = useAttrs();
const products = ref(attrs.products);
</script>

<template>
  <Head title="Product" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-3 flex flex-auto sm:justify-between">
              <Link :href="route('products.create')">
                <button type="button" class="btn btn-primary">Create</button>
              </Link>
              <input
                type="text"
                class="input input-bordered hidden sm:block"
                placeholder="Search product"
              />
              <button class="btn btn-primary btn-outline sm:hidden">Search</button>
            </div>

            <div class="overflow-x-auto w-full">
              <table class="table w-full">
                <!-- head -->
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="({ name, is_active }, index) in products">
                    <td>{{ index + 1 }}.</td>
                    <td>{{ name }}</td>
                    <td>
                      <span
                        class="badge text-white w-24"
                        :class="{
                          'badge-accent': is_active,
                          'badge-error': !is_active,
                        }"
                      >
                        {{ is_active ? "Active" : "Inactive" }}
                      </span>
                    </td>
                    <th>
                      <button type="button" class="btn btn-xs btn-info">Details</button>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
