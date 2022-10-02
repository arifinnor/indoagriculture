<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import VueFeather from 'vue-feather';

const props = defineProps(['product', 'locale']);
const images = props.product.product_images;
const properties = props.product.attributes;

const cover = images.find(item => {
  return item.type = 'background'
});

const filteredProperties = properties.filter(item => {
  return item.pivot.value != null && item.language === props.locale;
});

const whatsappUs = () => { window.open('https://wa.me/6281331261210?text=Hello, Can you help me with my order?') }

</script>

<template>

  <Head :title="props.product.name" />

  <div class="container rounded outline-none mx-auto my-10 py-10">
    <Link href="/#our-products" class="absolute btn btn-circle btn-outline flex justify-center items-center mx-8">
    <vue-feather type="arrow-left"></vue-feather>
    </Link>
    <div class="flex flex-col lg:flex-row lg:gap-12 justify-center items-center mx-8">
      <div class="w-full lg:w-1/2">
        <img :src="cover.url" alt="cover-image">
      </div>

      <div class="w-full lg:w-1/2">
        <h1 v-if="props.locale === 'en'"
          class="font-extrabold text-2xl text-center md:text-left md:text-3xl text-gray-900 mb-4">
          {{ props.product.name }}
        </h1>

        <h1 v-if="props.locale === 'de'"
          class="font-extrabold text-2xl text-center md:text-left text-l md:text-3xl text-gray-900 mb-4">
          {{ props.product.name_de }}
        </h1>

        <div class="mb-6">
          <p v-if="props.locale === 'en'" class="text-gray-700 md:text-2xl text-justify">
            {{ props.product.description }}
          </p>

          <p v-if="props.locale === 'de'" class="text-gray-700 md:text-2xl text-justify">
            {{ props.product.description_de }}
          </p>
        </div>

        <div v-for="property in filteredProperties" class="flex flex-row gap-2 mb-4">
          <div class="min-w-fit max-w-3xl md:w-52 md:text-base">
            {{ property.name }}
          </div>
          <div class="w-full max-w-fit">:</div>
          <div class="min-w-fit w-full md:text-base">{{ property.pivot.value }}</div>
        </div>

        <div class="my-6 flex flex-col md:flex-row">
          <button type="button" class="btn btn-primary flex flex-row gap-2 lg:btn-wide" @click.prevent="whatsappUs()">
            <vue-feather type="shopping-cart"></vue-feather>
            <span>Order now!</span>
          </button>
        </div>

      </div>

    </div>
  </div>

</template>