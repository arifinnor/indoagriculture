<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import FileInput from "@/Components/FileInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import VueFeather from "vue-feather";
import {computed} from "vue";

const props = defineProps({
  product_attributes: Array
});

const initialAttributes = props.product_attributes?.map(item => {
  return { ...item, value: "" };
});

const form = useForm({
  name: null,
  name_de: null,
  description: null,
  description_de: null,
  thumbnail: null,
  background: null,
  attrs: initialAttributes,
});

const type = {
  thumbnail: 'Thumbnail photo (MAX. 1400x1400px)',
  background: 'Cover photo (MAX. 2400x2400px)'
}

const classObject = computed(() => ({
  'bg-sky-50': true
}));

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
              <div class="lg:flex lg:flex-row lg:gap-4">
                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="What's your product's name?" />
                  <BreezeInput v-model="form.name" type="text" class="input input-bordered w-full"
                    placeholder="Type here" />
                  <div class="mt-1 font-medium text-red-600" v-if="form.errors.name">
                    {{ form.errors.name }}
                  </div>
                </div>
                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="Your product's name too, but in Germany." />
                  <BreezeInput v-model="form.name_de" type="text" class="input input-bordered w-full bg-sky-50"
                    placeholder="Type here" />
                  <div class="mt-1 font-medium text-red-600" v-if="form.errors.name_de">
                    {{ form.errors.name_de }}
                  </div>
                </div>
              </div>
              <div class="lg:flex lg:flex-row lg:gap-4">
                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="How's your product?" />
                  <textarea v-model="form.description" class="textarea textarea-bordered w-full h-48"
                    placeholder="Type here"></textarea>
                  <div class="mt-1 font-medium text-red-600" v-if="form.errors.description">
                    {{ form.errors.description }}
                  </div>
                </div>

                <div class="mt-3 w-full lg:max-w-[50%]">
                  <BreezeLabel value="Your product's description, but in Germany." />
                  <textarea v-model="form.description_de" class="textarea textarea-bordered w-full h-48 bg-sky-50"
                    placeholder="Type here"></textarea>
                  <div class="mt-1 font-medium text-red-600" v-if="form.errors.description_de">
                    {{ form.errors.description_de }}
                  </div>
                </div>

              </div>
              <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
                <template v-for="(attribute) in form.attrs">
                  <div class="form-control">
                    <BreezeLabel for="attribute.name" :value="attribute.name" />
                    <BreezeInput v-model="attribute.value" type="text" class="input input-bordered w-full" :class="{ 'bg-sky-50': attribute.language === 'de' }"
                      :placeholder="attribute.name" />
                    <BreezeInput v-model="attribute.id" type="hidden"></BreezeInput>
                  </div>
                </template>
              </div>
              <div class="form-control mt-3">
                <FileInput v-model="form.thumbnail" :type="type.thumbnail" id="thumbnail" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{ form.progress.percentage }}%
                </progress>
                <div class="mt-1 font-medium text-red-600" v-if="form.errors.thumbnail">
                  {{ form.errors.thumbnail }}
                </div>
              </div>
              <div class="form-control mt-3">
                <FileInput v-model="form.background" :type="type.background" id="background" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{ form.progress.percentage }}%
                </progress>
                <div class="mt-1 font-medium text-red-600" v-if="form.errors.background">
                  {{ form.errors.background }}
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
                  <span>Save</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
