<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import VueFeather from 'vue-feather';

const props = defineProps(['product']);
const title = props.product.name;
const description = props.product.description
const images = props.product.product_images;
const properties = props.product.attributes;
const cover = images.find(item => {
  return item.type = 'background'
});
const coverUrl = `/storage/${cover.url}`;
const filteredProperties = properties.filter(item => {
  return item.pivot.value != null;
})

</script>

<template>

  <Head :title="title" />

  <div class="container rounded outline-none mx-auto my-10 py-10">
    <div class="flex flex-col lg:flex-row gap-4 sm:gap-12 justify-center items-center mx-4">
      <div class="basis-1/2">
        <img class="rounded-xl" :src="coverUrl" alt="cover-image">
      </div>
      <div class="basis-1/2">
        <h1 class="font-extrabold text-2xl md:text-3xl text-gray-900"> {{ title }}</h1>

        <div class="my-6">
          <p class="text-gray-700 text-xl">{{ description }}</p>
        </div>

        <template v-for="property in filteredProperties">
          <div class="flex flex-row gap-2 my-6">
            <div class="basis-1/3 sm:basis-1/4">{{ property.name }}</div>
            <div class="basis-5">:</div>
            <div class="basis-1">{{ property.pivot.value }}</div>
          </div>
        </template>

        <div class=" flex flex-row gap-1 my-6">
          <vue-feather type="check" stroke="green"></vue-feather>
          <p class="text-gray-400"> In stock and ready to ship</p>
        </div>

        <div class="my-6 flex flex-col lg:flex-row">
          <button type="button" class="btn btn-primary flex flex-row gap-2 lg:btn-wide">
            <vue-feather type="shopping-cart"></vue-feather>
            <span>Order now!</span>
          </button>
        </div>

      </div>
    </div>
  </div>

</template>