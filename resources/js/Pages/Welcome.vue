<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { onMounted, computed } from "vue";

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  product_images: Array,
});

const images = props.product_images;

const hamburgerMenu = () => {
  const hamburger = document.querySelector("#hamburger-menu");
  hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("hamburger-active");
  });
};

const thumbnails = computed(() => {
  const imageArr = [];
  images.forEach(image => {
    imageArr.push(image.thumbnail)
  });
  return imageArr;
})

// lifecycle hooks
onMounted(() => {
  hamburgerMenu();
});
</script>

<template>

  <Head title="Welcome" />

  <!-- navbar -->
  <header class="bg-transparent absolute top-0 left-0 w-full flex items-center z-10">
    <div class="container">
      <div class="flex items-center justify-between relative">
        <div class="px-4">
          <a href="#home" class="font-bold text-lg text-slate-100 block py-6">
            Indo Tropical Agriculture
          </a>
        </div>
        <div class="flex items-center px-4">
          <button type="button" id="hamburger-menu" class="block absolute right-4">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
          </button>
        </div>
      </div>
    </div>
  </header>
  <!-- End navbar -->

  <!-- Home -->
  <section class="max-h-screen w-screen" id="home">
    <div class="hero min-h-screen" style="background-image: url(https://api.lorem.space/image/pizza?w=1000&h=800)">
      <div class="hero-overlay bg-opacity-60"></div>
      <div class="hero-content text-center text-neutral-content">
        <div class="max-w">
          <h1 class="mb-5 text-3xl font-bold sm:text-4xl md:text-5xl lg:text-6xl">
            Supplying across the world
          </h1>
          <p class="mb-5 text-base sm:text-2xl md:text-3xl lg:text-4xl">
            Indonesian agriculture supplier, trader and exporter.
          </p>
          <a href="#our-products" class="btn btn-primary">Get Started</a>
        </div>
      </div>
    </div>
  </section>
  <!-- End home -->

  <!-- Our products -->
  <section class="container mx-auto my-52" id="our-products">
    <h1 class="text-5xl text-slate-700 text-center font-bold py-12">Our Products</h1>
    <div class="flex flex-wrap gap-4 justify-center items-center h-full md:h-fit">
      <template v-for="thumbnail in thumbnails">
        <div class="avatar">
          <div class="w-72 rounded-full bg-base-100">
            <a :href="route('summary', thumbnail.product_id)">
              <img :src="`storage/${thumbnail.url}`" alt="Products" />
            </a>
          </div>
        </div>

      </template>

    </div>
  </section>
  <!-- End our products -->

  <!-- Contact us -->
  <section class="min-h-screen w-full bg-contain md:bg-cover md:bg-left"
    style="background-image: url('/storage/bg-1.png')" id="contact-us">
    <h1 class=" py-12 text-5xl text-center text-slate-200 font-bold">Contact Us</h1>
    <div class="grid grid-cols-2">
      <div></div>
      <div>
        <p class="text-slate-200 text-center text-xl lg:text-2xl font-bold">
          INDO TROPICAL AGRICULTURE
        </p>
        <p class="text-slate-400 text-center text-xl lg:text-2xl font-semibold">
          INTERNATIONAL EXPORTS AND SALES DEPARTMENT
        </p>
        <!-- <table class="table-auto">
          <tbody>
            <tr>
              <td>Export Customer Sales</td>
              <td>:</td>
              <td>+62813 3126 1210</td>
            </tr>
            <tr>
              <td>WHATSAPP</td>
              <td>:</td>
              <td class="text-right">+62813 3126 1210 (ENGLISH)</td>
            </tr>
            <tr>
              <td colspan="3" class="text-right">+62812 3666 994 (DEUTCH)</td>
            </tr>
            <tr>
              <td>EMAIL</td>
              <td>:</td>
              <td>EXPORTS@INDOTROPICALAGRICULTURE.COM</td>
            </tr>
          </tbody>
        </table> -->
      </div>
    </div>
  </section>
  <!-- End contact us -->

</template>

<style scoped>
</style>
