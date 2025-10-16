<script setup>
import { useI18n } from 'vue-i18n';
const { locale, t } = useI18n();
</script>

<template>
  <div class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <div class="max-w-5xl mx-auto p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ t('title') }}</h1>
        <select v-model="locale" class="border rounded px-2 py-1">
          <option value="pt" class="text-gray-900">Português</option>
          <option value="en" class="text-gray-900">English</option>
        </select>
      </div>
      <router-view />
    </div>
  </div>
</template>
