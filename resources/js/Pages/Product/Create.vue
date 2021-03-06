<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeButton from "@/Components/Button.vue";
import FileInput from "@/Components/FileInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import VueFeather from "vue-feather";

const props = defineProps({
  product_attributes: Array
});

const initialAttributes = props.product_attributes?.map((item) => {
  return { ...item, value: "" };
});

const form = useForm({
  name: null,
  description: null,
  images: {
    thumbnail: null,
    background: null,
  },
  attrs: initialAttributes,
});

const type = {
  thumbnail: 'Thumbnail photo (MAX. 800x800px)',
  background: 'Cover photo (MAX. 1200x1200px)'
}

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
            <form @submit.prevent="submit()">
              <div class="form-control mt-3">
                <BreezeLabel value="What is your product name?" />
                <BreezeInput v-model="form.name" type="text" class="input input-bordered w-full"
                  placeholder="Type here" />
                <div class="mt-1 font-medium text-red-600" v-if="form.errors.name">
                  {{ form.errors.name }}
                </div>

              </div>
              <div class="form-control mt-3">
                <BreezeLabel value="How is your product?" />
                <textarea v-model="form.description" class="textarea textarea-bordered w-full h-48"
                  placeholder="Type here"></textarea>
                <div class="mt-1 font-medium text-red-600" v-if="form.errors.description">
                  {{ form.errors.description }}
                </div>

              </div>
              <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
                <template v-for="(attribute, index) in form.attrs">
                  <div class="form-control">
                    <BreezeLabel for="attribute.name" :value="attribute.name" />
                    <BreezeInput v-model="attribute.value" type="text" class="input input-bordered w-full"
                      :placeholder="attribute.name" />
                    <BreezeInput v-model="attribute.id" type="text" class="hidden"></BreezeInput>
                  </div>
                </template>
              </div>
              <div class="form-control mt-3">
                <!-- <input type="file" accept="image" @input="form.images.thumbnail = $event.target.file[0]"> -->
                <FileInput v-model="form.images.thumbnail" :type="type.thumbnail" id="thumbnail" />
              </div>
              <div class="form-control mt-3">
                <FileInput v-model="form.images.background" :type="type.background" id="background" />
              </div>
              <div class="flex items-center justify-end mt-4">
                <Link :href="route('products.index')" class="btn btn-sm btn-link text-red-600">
                <span class="flex items-center justify-between gap-1">
                  <vue-feather type="x"></vue-feather>
                  Cancel
                </span>
                </Link>

                <BreezeButton class="ml-4 btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  <span class="flex items-center justify-between gap-1">
                    <vue-feather type="send"></vue-feather>
                    Save
                  </span>
                </BreezeButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
