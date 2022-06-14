<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, useAttrs, onMounted } from "vue";

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
                <input
                  v-model="form.name"
                  type="text"
                  placeholder="Type here"
                  class="input input-bordered w-full"
                />
                <BreezeValidationErrors class="mt-1" />
              </div>
              <div class="flex items-center justify-end mt-4">
                <Link
                  :href="route('attributes.index')"
                  class="btn btn-error btn-outline btn-sm"
                >
                  Cancel
                </Link>

                <BreezeButton
                  class="ml-4 btn btn-sm"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Save
                </BreezeButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
