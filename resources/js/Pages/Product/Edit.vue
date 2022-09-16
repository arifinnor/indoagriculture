<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import FileInput from "@/Components/FileInput.vue";
import VueFeather from "vue-feather";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';


const props = defineProps({
  product: {
    id: Int32Array,
    name: String,
    description: String,
    name_de: String,
    description_de: String,
    is_active: Boolean,
    attributes: Array,
    thumbnail: Object,
    cover: Object,
  }
});

const type = {
  thumbnail: 'Thumbnail photo (MAX. 1400x1400px)',
  background: 'Cover photo (MAX. 2400x2400px)'
}

const form = reactive({
  name: props.product.name,
  description: props.product.description,
  name_de: props.product.name_de,
  description_de: props.product.description_de,
  is_active: props.product.is_active,
  thumbnail: `/storage/${props.product.thumbnail.url}`,
  background: `/storage/${props.product.cover.url}`,
  attrs: [],
});

const update = () => {
  form.attrs = props.product.attributes.map((item) => {
    return {
      id: item.pivot.attribute_id,
      value: item.pivot.value
    };
  });

  Inertia.post(route('products.update', props.product.id), {
    _method: 'put',
    name: form.name,
    description: form.description,
    name_de: form.name_de,
    description_de: form.description_de,
    is_active: form.is_active,
    thumbnail: form.thumbnail,
    background: form.background,
    attrs: form.attrs,

  });

}

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
                <select v-model="form.is_active" class="select select-bordered w-full max-w-[25%]">
                  <option value="true">Yes, of course!</option>
                  <option value="false">No, I don't think so.</option>
                </select>
                <div class="mt-1 font-medium text-red-600" v-if="$attrs.errors.is_active">
                  {{ $attrs.errors.is_active }}
                </div>
              </div>
              <div class="lg:flex lg:flex-row lg:gap-4">
                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="What's your product's name?" />
                  <BreezeInput v-model="form.name" type="text" class="input input-bordered w-full"
                    placeholder="Type here" required />
                  <div class="mt-1 font-medium text-red-600" v-if="$attrs.errors.name">
                    {{ $attrs.errors.name }}
                  </div>
                </div>
                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="Your product's name too, but in Germany." />
                  <BreezeInput v-model="form.name_de" type="text" class="input input-bordered w-full bg-sky-50"
                    placeholder="Type here" required />
                  <div class="mt-1 font-medium text-red-600" v-if="$attrs.errors.name_de">
                    {{ $attrs.errors.name_de }}
                  </div>
                </div>
              </div>
              <div class="lg:flex lg:flex-row lg:gap-4">
                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="How's your product?" />
                  <textarea v-model="form.description" class="textarea textarea-bordered w-full h-48"
                    placeholder="Type here"></textarea>
                  <div class="mt-1 font-medium text-red-600" v-if="$attrs.errors.description">
                    {{ $attrs.errors.description }}
                  </div>
                </div>
                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="Your product's description, but in Germany." />
                  <textarea v-model="form.description_de" class="textarea textarea-bordered w-full h-48 bg-sky-50"
                    placeholder="Type here"></textarea>
                  <div class="mt-1 font-medium text-red-600" v-if="$attrs.errors.description_de">
                    {{ $attrs.errors.description_de }}
                  </div>
                </div>
              </div>


              <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
                <template v-for="property in props.product.attributes">
                  <div class="form-control">
                    <BreezeLabel :for="property.name" :value="property.name" />
                    <BreezeInput v-model="property.pivot.value" type="text" :id="property.name"
                      class="input input-bordered w-full" :class="{'bg-sky-50': property.language === 'de'}" placeholder="empty" />
                    <BreezeInput v-model="property.id" type="hidden" class="input input-bordered w-full"
                      :placeholder="property.id" />
                  </div>
                </template>
              </div>
              <div class="form-control mt-3">
                <FileInput v-model="form.thumbnail" :type="type.thumbnail" id="thumbnail" />
                <div class="mt-1 font-medium text-red-600" v-if="$attrs.errors.thumbnail">
                  {{ $attrs.errors.thumbnail }}
                </div>

              </div>
              <div class="form-control mt-3">
                <FileInput v-model="form.background" :type="type.background" id="background" />
                <div class="mt-1 font-medium text-red-600" v-if="$attrs.errors.background">
                  {{ $attrs.errors.background }}
                </div>
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
