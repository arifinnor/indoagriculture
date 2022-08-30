<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import FileInput from "@/Components/FileInput.vue";
import VueFeather from "vue-feather";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { computed, onMounted, ref } from 'vue';


const props = defineProps({
  product: {
    id: Int32Array,
    name: String,
    description: String,
    is_active: Boolean,
    attributes: Array,
    thumbnail: Object,
    cover: Object,
  }
});

const type = {
  thumbnail: 'Thumbnail photo (MAX. 1200x1200px)',
  background: 'Cover photo (MAX. 1200x1200px)'
}

const thumbnailUrl = `/storage/${props.product.thumbnail.url}`;
const coverUrl = `/storage/${props.product.cover.url}`;

const form = useForm({
  name: props.product.name,
  description: props.product.description,
  is_active: props.product.is_active,
  thumbnail: thumbnailUrl,
  background: coverUrl,
  attrs: [],
});

const update = () => {
  form.attrs = props.product.attributes.map((item) => {
    return {
      id: item.pivot.attribute_id,
      value: item.pivot.value
    };
  });

  form.put(route('products.update', props.product.id));

}

// async function createFile(url, name) {
//   const response = await fetch(url);
//   const data = await response.blob();
//   const metadata = {
//     type: 'image/jpeg'
//   };
//   const file = new File([data], name, metadata);
//   // ... do something with the file or return it

//   return file;
// }


</script>

<template>

  <Head title="Product" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit product information</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="update">
              <div class="form-control mt-3">
                <BreezeLabel value="Is it still active?" />
                <select v-model="form.is_active" class="select select-bordered w-full max-w-xs">
                  <option value="true">Yes, of course!</option>
                  <option value="false">No, I don't think so.</option>
                </select>
              </div>
              <div class="form-control mt-3">
                <BreezeLabel value="What's your product name?" />
                <BreezeInput v-model="form.name" type="text" class="input input-bordered w-full" placeholder="Type here"
                  required />
                <div class="mt-1 font-medium text-red-600" v-if="form.errors.name">
                  {{  form.errors.name  }}
                </div>
              </div>
              <div class="form-control mt-3">
                <BreezeLabel value="How's your product?" />
                <textarea v-model="form.description" class="textarea textarea-bordered w-full h-48"
                  placeholder="Type here"></textarea>
              </div>
              <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
                <template v-for="(property, index) in props.product.attributes">
                  <div class="form-control">
                    <BreezeLabel :for="property.name" :value="property.name" />
                    <BreezeInput v-model="property.pivot.value" type="text" :id="property.name"
                      class="input input-bordered w-full" placeholder="empty" />
                    <BreezeInput v-model="property.id" type="hidden" class="input input-bordered w-full"
                      :placeholder="property.id" />
                  </div>
                </template>
              </div>
              <div class="form-control mt-3">
                <FileInput v-model="thumbnailUrl" :type="type.thumbnail" id="thumbnail" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{  form.progress.percentage  }}%
                </progress>
              </div>
              <div class="form-control mt-3">
                <FileInput v-model="coverUrl" :type="type.background" id="background" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{  form.progress.percentage  }}%
                </progress>
              </div>
              <div class="flex items-center justify-end mt-4">
                <Link :href="route('products.index')" class="btn btn-error btn-outline gap-1">
                <vue-feather type="rotate-ccw"></vue-feather>
                <span>Cancel</span>
                </Link>
                <button type="submit" class="ml-4 btn btn-primary gap-1" :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing">
                  <vue-feather type="save"></vue-feather>
                  Update
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
