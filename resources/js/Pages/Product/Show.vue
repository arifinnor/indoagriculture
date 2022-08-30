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
});
const whatsappUs = () => { window.open('https://wa.me/6281331261210?text=Hello, Can you help me with my order?') }

</script>

<template>

  <Head :title="title" />

  <div class="container rounded outline-none mx-auto my-10 py-10">
    <div class="flex flex-col lg:flex-row gap-4 sm:gap-12 justify-center items-center mx-4">

      <div class=" w-1/2">
        <img class="rounded-xl" :src="coverUrl" alt="cover-image">
      </div>

      <div class="w-1/2">
        <h1 class="font-extrabold text-2xl text-center md:text-left md:text-3xl text-gray-900 mb-4"> {{  title  }}</h1>
        <div class="my-6">
          <p class="text-gray-700 text-xl md:text-2xl text-center md:text-left">{{  description  }}</p>
        </div>

        <div v-for="property in filteredProperties" class="flex flex-row gap-2 mb-4">
          <div class="min-w-fit max-w-3xl w-52 text-sm md:text-base">{{  property.name  }}</div>
          <div class="w-fit text-sm md:text-base">:</div>
          <div class="min-w-fit w-full text-sm md:text-base">{{  property.pivot.value  }}</div>
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