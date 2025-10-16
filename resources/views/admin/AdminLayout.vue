<script setup>
import LocaleSwitcher from '../../js/LocaleSwitcher.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <header class="border-b border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-800/70 backdrop-blur">
      <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <h1 class="text-lg font-semibold">Painel | Agenda</h1>
        <nav class="text-sm text-gray-600 dark:text-gray-300">
          <router-link class="hover:underline" :to="{ name: 'admin.contacts' }">Contatos</router-link>
        </nav>
      </div>
    </header>
    <main class="max-w-7xl mx-auto p-4">
      <LocaleSwitcher />
    </main>
  </div>
</template>

<style scoped>

</style>
