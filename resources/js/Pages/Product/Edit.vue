<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeButton from "@/Components/Button.vue";

import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { computed } from 'vue';

const props = defineProps({
  product: {
    name: String,
    description: String,
    product_attributes: Array,
    product_images: Array,
  },
  properties: Array,
});

// const initialAttributes = props.properties?.map((item) => {
//   return { ...item, value: "" };
// });

const form = useForm({
  name: props.product.name,
  description: props.product.description,
  images: props.product_images,
  attrs: props.product.product_attributes,
});

// const propertiesWithValue = computed(() => {
//   const val = props.product_attributes.filter((item) => {
//     return item.id === 1
//   })
//   console.log(val[0].value);
//   // return val.id;
// });

const submit = () => {
  form.post(route('products.store'));
}
</script>

<template>

  <Head title="Product" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add new product</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit">
              <div class="form-control mt-3">
                <BreezeLabel value="What is your product name?" />
                <BreezeInput v-model="form.name" type="text" class="input input-bordered w-full" placeholder="Type here"
                  required />
              </div>
              <div class="form-control mt-3">
                <BreezeLabel value="How is your product?" />
                <textarea v-model="form.description" class="textarea textarea-bordered w-full h-48"
                  placeholder="Type here"></textarea>
              </div>
              <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
                <template v-for="(property, index) in form.attrs">
                  <div class="form-control">
                    <BreezeLabel :for="property.name" :value="property.name" />
                    <BreezeInput v-model="property.value" type="text" :id="property.name"
                      class="input input-bordered w-full" :placeholder="property.name" />
                    <BreezeInput v-model="property.id" type="hidden" class="input input-bordered w-full"
                      :placeholder="property.id" />

                  </div>
                </template>
              </div>
              <div class="form-control mt-3">
                <input type="file" @input="form.images.thumbnail = $event.target.files[0]" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{ form.progress.percentage }}%
                </progress>
              </div>
              <div class="form-control mt-3">
                <input type="file" @input="form.images.background = $event.target.files[0]" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{ form.progress.percentage }}%
                </progress>
              </div>
              <div class="flex items-center justify-end mt-4">
                <Link :href="route('products.index')" class="btn btn-error btn-outline btn-sm">
                Cancel
                </Link>

                <BreezeButton class="ml-4 btn btn-sm" :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing">
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
