<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { useAttrs } from 'vue';
import VueFeather from 'vue-feather';
import { Inertia } from '@inertiajs/inertia';

const { attribute } = useAttrs();
const form = useForm(attribute);
const update = () => {
  form.put(`/attributes/${form.id}`);
};
const destroy = () => {
  Inertia.delete(`/attributes/${attribute.id}`);
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
            <form @submit.prevent="update">
              <div class="form-control w-full">
                <label class="label">
                  <span class="label-text">What is your product properties name?</span>
                </label>
                <input v-model="form.name" type="text" placeholder="Type here" class="input input-bordered w-full" />
                <BreezeValidationErrors class="mt-1" />
              </div>
              <div class="flex flex-wrap justify-between mt-4">
                <div class="flex flex-wrap gap-2">
                  <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    <vue-feather type="save"></vue-feather>
                    <span class="px-2">Update property</span>
                  </BreezeButton>
                  <!-- <Link :href="route('attributes.index')" class="btn btn-sm btn-ghost">
                  <vue-feather type="rotate-ccw"></vue-feather>
                  <span class="px-2">Back to previous page</span>
                  </Link> -->
                </div>
                <div>
                  <label for="modal-confirm" class="btn btn-link btn-error text-error modal-button">
                    Delete property
                  </label>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="modal-confirm" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
      <div class="modal-box">
        <div class="flex flex-col justify-center items-center">
          <vue-feather type="alert-triangle" size="60" class="text-error" />
          <h2 class="font-bold text-lg text-error-content">Are you sure?</h2>
          <p class="py-4">
            You won't be able to revert this!
          </p>
        </div>
        <div class="flex flex-nowrap gap-2 justify-center items-center">
          <button type="button" class="btn btn-sm w-36 btn-accent" @click.prevent="destroy()">Yes, delete it!</button>
          <label for="modal-confirm" class="btn btn-sm w-36 btn-error">Cancel</label>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
