<template>
  <div class="min-h-full">
    <NavBar />

    <TopHeader />

    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">

import { defineAsyncComponent } from 'vue'

const TopHeader = defineAsyncComponent(() => import('./components/TopHeader.vue'))
const NavBar = defineAsyncComponent(() => import('./components/NavBar.vue'))

</script>
