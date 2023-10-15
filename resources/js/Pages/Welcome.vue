<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { onMounted, ref } from "vue";
import VueFeather from 'vue-feather';

const props = defineProps({
  product_images: Array,
  locale: String,
});

const hero = ref({});
const vision = ref({});
const mission = ref({});
const product = ref('');
const contact = ref('');

const lang = props.locale;
const images = props.product_images;
const menus = [
  { name: 'Home', link: '#home', isActive: false, lang: 'en' },
  { name: 'Home', link: '#home', isActive: false, lang: 'de' },
  { name: 'Our Products', link: '#', isActive: false, lang: 'en', child: ['Planting Media', 'Spices', 'Tropical Fruit'] },
  { name: 'Unseres Produkt', link: '#', isActive: false, lang: 'de', child: ['Planting Media', 'Spices', 'Tropical Fruit'] },
  { name: 'Contact Us', link: '#contact-us', isActive: false, lang: 'en' },
  { name: 'Kontakt Uns', link: '#contact-us', isActive: false, lang: 'de' },
];

const heroes = [
  {
    lang: 'en',
    title: 'Supplying across the world',
    body: 'Indonesian agriculture supplier, trader and exporter.',
    button: 'Getting started'
  },
  {
    lang: 'de',
    title: 'Weltweit Versorgen',
    body: 'Indonesischer landwirtschaftslieferant, händler und exporteur.',
    button: 'lóslegen'
  }
];

const visions = [
  {
    lang: 'en',
    title: 'Our Vision',
    text: 'Providing fresh and high quality of Indonesian agricultural products.'
  },
  {
    lang: 'de',
    title: 'Unsere Vision',
    text: 'Bereitstellung der frisch und hochwertig indonesichen Agrarprodukte.'
  }
];

const missions = [
  {
    lang: 'en',
    title: 'Our Mission',
    text: 'To realize our vision we are committed to support Indonesian farmer to improve their well-being and quality of life through providing education and training.'
  },
  {
    lang: 'de',
    title: 'Unsere Mission',
    text: 'Um unsere Vision zu verwirklichen, setzen wir uns dafür ein, indonesische Bauern zu unterstützen, ihr Wohlergehen und ihre Lebensqualität durch Bildung und Ausbildung zu verbessern.'
  }
];

function localizedMenus(lang = 'en') {
  return menus.filter(menu => menu.lang == lang);
}

function localize(lang = 'en') {
  hero.value = heroes.find(hero => hero.lang == lang);
  vision.value = visions.find(vision => vision.lang == lang);
  mission.value = missions.find(mission => mission.lang == lang);

  lang == 'en' ? product.value = 'Our Product' : product.value = 'Unseres Produkt';
  lang == 'en' ? contact.value = 'Contact Us' : contact.value = 'Kontakt Uns';
}

onMounted(() => {
  localize(lang);
});


</script>

<template>
  <Head title="Welcome" />

  <!-- navbar -->
  <div class="navbar bg-base-200 sticky top-0 left-0 z-50 opacity-80 shadow-lg lg:shadow-2xl">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost lg:hidden">
          <VueFeather type="menu" stroke="currentColor"></VueFeather>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li v-for="menu in localizedMenus(lang)">
            <template v-if="!menu.child">
              <a :href="menu.link" :class="{ active: menu.isActive }">{{ menu.name }}</a>
            </template>
            <template v-else>
              <span>
                {{ menu.name }}
                <svg v-if="menu.child" class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                  viewBox="0 0 24 24">
                  <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                </svg>
              </span>
            </template>
            <ul class="bg-base-100" v-if="menu.child">
              <li v-for="submenu in menu.child">
                <a href="#">{{ submenu }}</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <a href="/" class="hidden md:inline-flex btn btn-ghost normal-case text-xl text-neutral">
        <span>Indo Tropical Agriculture</span>
      </a>
      <a href="/" class="md:hidden btn btn-ghost normal-case text-xl text-neutral">IAT</a>
    </div>
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal px-1">
        <li v-for="menu in localizedMenus(lang)">
          <a :href="menu.link" :class="{ active: menu.isActive }" class="font-bold justify-between">
            {{ menu.name }}
            <svg v-if="menu.child" class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
              viewBox="0 0 24 24">
              <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
            </svg>
          </a>
          <ul v-if="menu.child" class="p-2 bg-base-100">
            <li v-for="submenu in menu.child"><a>{{ submenu }}</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div class=" navbar-end">
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-outlined btn-circle btn-primary m-1">{{ lang }}</label>
        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-200 rounded-box w-52">
          <li>
            <a :href="route('lang', 'en')">
              <svg class="mr-2 w-5 h-5 rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3900 3900">
                <path fill="#b22234" d="M0 0h7410v3900H0z" />
                <path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff" stroke-width="300" />
                <path fill="#3c3b6e" d="M0 0h2964v2100H0z" />
                <g fill="#fff">
                  <g id="d">
                    <g id="c">
                      <g id="e">
                        <g id="b">
                          <path id="a" d="M247 90l70.534 217.082-184.66-134.164h228.253L176.466 307.082z" />
                          <use xlink:href="#a" y="420" />
                          <use xlink:href="#a" y="840" />
                          <use xlink:href="#a" y="1260" />
                        </g>
                        <use xlink:href="#a" y="1680" />
                      </g>
                      <use xlink:href="#b" x="247" y="210" />
                    </g>
                    <use xlink:href="#c" x="494" />
                  </g>
                  <use xlink:href="#d" x="988" />
                  <use xlink:href="#c" x="1976" />
                  <use xlink:href="#e" x="2470" />
                </g>
              </svg>
              EN
            </a>
          </li>

          <li>
            <a :href="route('lang', 'de')">
              <svg class="h-3.5 w-3.5 rounded-full mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                id="flag-icon-css-de" viewBox="0 0 512 512">
                <path fill="#ffce00" d="M0 341.3h512V512H0z" />
                <path d="M0 0h512v170.7H0z" />
                <path fill="#d00" d="M0 170.7h512v170.6H0z" />
              </svg>
              DE
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- End navbar -->

  <!-- Home -->
  <section class="h-screen w-screen" id="home">
    <div class="hero h-screen" style="background-image: url('/storage/hero-image.jpeg')">
      <div class="hero-overlay bg-opacity-60"></div>
      <div class="hero-content text-center text-neutral-content">
        <div class="max-w">
          <h1 class="mb-5 text-3xl font-bold sm:text-4xl md:text-5xl lg:text-6xl">
            {{ hero.title }}
          </h1>
          <p class="mb-5 text-base sm:text-2xl md:text-3xl lg:text-4xl">
            {{ hero.body }}
          </p>
          <a href="#our-products" class="btn btn-primary btn-wide text-neutral-content rounded-xl">
            {{ hero.button }}
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- End home -->

  <!-- Vision and mission -->
  <section class="min-h-screen w-full bg-gray-50 " id="about-us">
    <div class="container mx-auto pb-16">
      <!-- Vision -->
      <div class="flex flex-col mx-4 md:mx-40 md:flex-row gap-4 md:gap-8 pt-8 md:pt-16 justify-center items-center">
        <div class="w-full md:w-1/2 flex justify-center">
          <img src="storage/vision.jpeg" alt="vision"
            class="w-64 h-64 lg:w-96 lg:h-96 rounded-full md:rounded-3xl shadow-2xl">
        </div>
        <div class="w-fit md:w-1/2">
          <h3 class="mb-2 md:mb-4 text-center md:text-left text-2xl lg:text-4xl text-slate-700 font-semibold">
            {{ vision.title }}
          </h3>
          <p class="text-center md:text-left text-slate-500 text-xl lg:text-2xl">
            {{ vision.text }}
          </p>
        </div>
      </div>
      <!-- End vision -->

      <!-- Mission -->
      <div class="flex flex-col mx-4 md:mx-40 md:flex-row gap-4 md:gap-8 pt-8 md:pt-16 justify-center items-center">
        <!-- Hidden when medium breakpoint -->
        <div class="md:w-1/2 md:hidden">
          <img src="storage/mision.jpeg" alt="mission"
            class="w-64 h-64 lg:w-96 ;g:h-96 shadow-2xl rounded-full md:rounded-3xl">
        </div>
        <div class="md:w-1/2 md:hidden">
          <h3 class="mb-2 md:mb-4 text-center md:text-left text-2xl lg:text-4xl text-slate-700 font-semibold">
            {{ mission.title }}
          </h3>
          <p class="text-center md:text-left text-slate-500 text-xl lg:text-2xl">
            {{ mission.text }}
          </p>
        </div>
        <!-- End hidden when medium breakpoint -->

        <!-- Hidden when mobile view -->
        <div class="md:w-1/2 hidden md:inline-block">
          <h3 class="mb-2 md:mb-4 text-center md:text-right text-2xl lg:text-4xl text-slate-700 font-semibold">
            {{ mission.title }}
          </h3>
          <p class="text-center md:text-right text-slate-500 text-xl lg:text-2xl">
            {{ mission.text }}
          </p>
        </div>
        <div class="md:w-1/2 hidden md:block">
          <img src="storage/mision.jpeg" alt="mission"
            class="w-64 h-64 lg:w-96 lg:h-96 shadow-2xl rounded-full md:rounded-3xl image-full">
        </div>
        <!-- End hidden when mobile view -->

      </div>
      <!-- End mission -->
    </div>

  </section>
  <!-- End vision and mission -->

  <!-- Our products -->
  <section class="max-h-full w-full bg-slate-200" id="our-products">
    <div class="container mx-auto pb-16">
      <h1 class="text-5xl text-slate-700 text-center font-bold py-16">{{ product }}</h1>
      <div class="flex flex-wrap gap-4 justify-center items-center h-fit">
        <template v-for="image in images" :key="image.id">
          <div class="w-72 h-72 bg-base-100 relative shadow-xl rounded-full">
            <div class="absolute inset-0 bg-cover bg-center z-0 rounded-full hover:opacity-0"
              :style="`background-image: url(${image.thumbnail.url})`">
            </div>
            <a :href="route('summary', image.thumbnail.product_id)">
              <span v-if="lang === 'en'"
                class="opacity-0 hover:opacity-100 duration-300 absolute inset-0 z-10 flex justify-center items-center text-2xl text-neutral-content font-semibold">
                {{ image.name }}
              </span>

              <span v-if="lang === 'de'"
                class="opacity-0 hover:opacity-100 duration-300 absolute inset-0 z-10 flex justify-center items-center text-2xl text-neutral-content font-semibold">
                {{ image.name_de }}
              </span>
            </a>
          </div>
        </template>
      </div>
    </div>
  </section>
  <!-- End our products -->

  <!-- Contact us -->
  <section class="min-h-screen w-full bg-green-700 bg-cover bg-right lg:bg-left lg:bg-contain"
    style="background-image: url('/storage/contact-us.png')" id="contact-us">
    <h1 class="text-5xl text-center text-slate-200 font-bold py-12">{{ contact }}</h1>
    <div class="flex justify-center items-center lg:grid lg:grid-cols-2">
      <div class="hidden lg:block"></div>
      <div>
        <p class="text-slate-200 text-center text-xl lg:text-2xl font-bold">
          INDO TROPICAL AGRICULTURE
        </p>
        <p class="text-slate-200 text-center text-xl lg:text-2xl font-semibold">
          INTERNATIONAL EXPORTS AND SALES DEPARTMENT
        </p>
        <div class="text-center text-lg lg:text-xl my-12">
          <div class="py-2">
            <p class=" text-slate-400 font-semibold">Export Customer Sales</p>
            <p class="text-slate-200">+62813 3126 1210</p>
          </div>
          <div class="py-2">
            <p class="text-slate-400 font-semibold">WHATSAPP</p>
            <p class="text-slate-200">+62813 3126 1210 (ENGLISH)</p>
            <p class="text-slate-200">+62812 3666 994 (DEUTCH)</p>
          </div>
          <div class="py-2">
            <p class="text-slate-400">EMAIL</p>
            <p class="text-slate-200">exports@indotropicalagriculture.com</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End contact us -->
</template>

<style scoped></style>
