<template>
    <transition name="fade">
      <div
        v-if="visible"
        :class="[
          'fixed top-5 right-5 px-4 py-3 rounded shadow text-white z-50',
          type === 'success' ? 'bg-green-600' : 'bg-red-600'
        ]"
      >
        {{ message }}
      </div>
    </transition>
  </template>

  <script setup>
  import { ref } from 'vue'

  const props = defineProps({
    duration: { type: Number, default: 3000 }
  })

  const visible = ref(false)
  const message = ref('')
  const type = ref('success')

  const show = (msg, toastType = 'success') => {
    message.value = msg
    type.value = toastType
    visible.value = true

    setTimeout(() => {
      visible.value = false
    }, props.duration)
  }

  defineExpose({ show })
  </script>

  <style>
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
  }
  .fade-enter-from, .fade-leave-to {
    opacity: 0;
  }
  </style>
