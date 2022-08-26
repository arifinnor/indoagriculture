<script setup>
import VueFeather from "vue-feather";
import { ref } from 'vue';

const props = defineProps(['modelValue', 'id', 'type']);
const emit = defineEmits(['update:modelValue']);
const imageUrl = ref(props.modelValue);

const previewImage = (e) => {
  const file = e.target.files[0];
  imageUrl.value = URL.createObjectURL(file);

  emit('update:modelValue', file);
}

const removeImage = () => {
  imageUrl.value = null;

  emit('update:modelValue', null);
}

</script>

<template>
  <div class="flex justify-center">
    <template v-if="modelValue">
      <div class="relative inline-block overflow-hidden">
        <img :src="imageUrl" class="w-auto h-64" alt="product-images">
        <div class="flex justify-center items-center absolute top-0 h-full w-full">
          <button type="button"
            class="btn btn-xl btn-outline btn-circle text-white hover:bg-white hover:opacity-25 hover:text-slate-400"
            @click="removeImage()">
            <VueFeather type="trash"></VueFeather>
          </button>
        </div>
      </div>
    </template>
    <template v-else class="w-full h-64">
      <label :for="id"
        class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer">
        <div class="flex flex-col justify-center items-center pt-5 pb-6">
          <VueFeather type="upload-cloud" size="32" class="text-gray-400" />
          <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
            <span class="font-semibold">Click to upload</span>
          </p>
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ type }}</p>
        </div>
        <input :id="id" type="file" accept="image/*" class="hidden" @input="previewImage" />
      </label>
    </template>
  </div>

</template>
