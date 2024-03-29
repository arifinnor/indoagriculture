<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import VueFeather from 'vue-feather';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  attribute: Object
});

const form = useForm({
  'id': props.attribute.id,
  'name': props.attribute.name,
  'language': props.attribute.language
});

const update = () => {
  form.put(route('attributes.update', form.id));
};

const destroy = () => {
  Inertia.delete(route('attributes.destroy', form.id));
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
              </div>
              <div class="form-control w-full">
                <label class="label">
                  <span class="label-text">What language is it?</span>
                </label>
                <select v-model="form.language" class="select select-bordered w-full max-w-xs">
                  <option disabled selected value="null">Select language</option>
                  <option value="en">English</option>
                  <option value="de">Deutch</option>
                </select>
                <BreezeValidationErrors class="mt-1" />
              </div>
              <div class="flex flex-wrap justify-between mt-4">
                <div class="flex gap-4">
                  <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <vue-feather type="save"></vue-feather>
                    <span class="px-2">Update</span>
                  </button>

                  <Link :href="route('attributes.index')" class="btn btn-error btn-outline gap-1">
                  <vue-feather type="rotate-ccw"></vue-feather>
                  <span>Cancel</span>
                  </Link>

                </div>
                <label for="modal-confirm" class="btn btn-error modal-button gap-1">
                  <vue-feather type="trash-2"></vue-feather>
                  <span>Delete</span>
                </label>
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
