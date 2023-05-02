<template>
  <div v-if="isLoading" class="fixed inset-0 flex items-center justify-center">
    <div class="relative">
      <div class="mx-auto w-16 h-16">
        <div class="spinner"></div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const props = defineProps({
  loading: {
    type: Boolean,
    default: false
  }
})

const isLoading = ref(props.loading)
</script>

<style lang="css">
.spinner {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: 5px solid rgba(0, 0, 0, 0.1);
  border-top-color: #1a202c;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>