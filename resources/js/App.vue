<script setup>
import { onMounted } from 'vue';
import { useContactsStore } from './contacts_store';
import { useI18n } from 'vue-i18n';
import LocaleSwitcher from '../js/LocaleSwitcher.vue';

const { t } = useI18n();
const store = useContactsStore();
onMounted(() => store.fetch());
</script>

<template>
  <div class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
      <router-view />
  </div>
</template>
