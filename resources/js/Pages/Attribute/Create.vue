<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import VueFeather from "vue-feather";

const form = useForm({
  name: null,
});

const submit = () => {
  form.post(route("attributes.store"));
};
</script>

<template>

  <Head title="Product" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Add new product properties
        </h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit">
              <div class="form-control w-full">
                <label class="label">
                  <span class="label-text">What is your product properties name?</span>
                </label>
                <input v-model="form.name" type="text" placeholder="Type here" class="input input-bordered w-full" />
                <BreezeValidationErrors class="mt-1" />
              </div>
              <div class="flex gap-4 mt-4">
                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing">
                  <vue-feather type="save"></vue-feather>
                  <span class="px-2">Save</span>
                </button>

                <Link :href="route('attributes.index')" class="btn btn-error btn-outline gap-1">
                <vue-feather type="rotate-ccw"></vue-feather>
                <span>Cancel</span>
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
