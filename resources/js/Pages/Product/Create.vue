<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";

import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, useAttrs } from "vue";

const { product_attributes } = useAttrs();
const initialAttributes = product_attributes?.map((item) => {
  return { ...item, value: "" };
});

const form = ref({
  name: null,
  description: null,
  attrs: initialAttributes,
});
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
            <form>
              <div class="form-control mt-3">
                <BreezeLabel for="name" value="What is your product name?" />
                <BreezeInput
                  v-model="form.name"
                  type="text"
                  class="input input-bordered w-full"
                  placeholder="Type here"
                  required
                />
              </div>
              <div class="form-control mt-3">
                <BreezeLabel for="description" value="How is your product?" />
                <textarea
                  id="description"
                  class="textarea textarea-bordered w-full h-48"
                  placeholder="Type here"
                ></textarea>
              </div>
              <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
                <template v-for="(attribute, index) in form.attrs">
                  <div class="form-control">
                    <BreezeLabel :for="attribute.name" :value="attribute.name" />
                    <BreezeInput
                      v-model="attribute.value"
                      type="text"
                      :id="attribute.name"
                      class="input input-bordered w-full"
                      :placeholder="attribute.name"
                      required
                    />
                  </div>
                </template>
              </div>
              <div class="form-control mt-3">
                <BreezeLabel for="thumbnail_img" value="Thumbnail image" />
                <input
                  class="block mt-1 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer"
                  aria-describedby="thumbnail_img_help"
                  id="thumbnail_img"
                  type="file"
                />
                <p class="mt-1 text-gray-500" id="thumbnail_img_help">
                  SVG, PNG, JPG or GIF (MAX. 800x400px).
                </p>
              </div>
              <div class="form-control mt-3">
                <BreezeLabel for="background_img" value="Background image" />
                <input
                  class="block mt-1 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer"
                  aria-describedby="background_img_help"
                  id="background_img"
                  type="file"
                />
                <p class="mt-1 text-gray-500" id="background_img_help">
                  SVG, PNG, JPG or GIF (MAX. 800x400px).
                </p>
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
