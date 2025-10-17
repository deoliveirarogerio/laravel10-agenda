<script setup>
import LocaleSwitcher from "../../js/LocaleSwitcher.vue";

import { useI18n } from 'vue-i18n';

const { t } = useI18n();

</script>

<template>
    <LocaleSwitcher />
  <div class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 flex items-center justify-center">
    <div class="w-full max-w-md">
      <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
          <h2 class="text-xl font-semibold">Login</h2>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ t('access_panel')}}</p>
        </div>

        <form class="px-6 py-5 space-y-5" action="#" method="post">
          <div>
            <label for="email" class="block text-sm font-medium mb-1">{{ t('email') }}</label>
            <input
              id="email"
              name="email"
              type="email"
              required
              autocomplete="email"
              class="block w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="email@email.com"
            />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium mb-1">{{ t('password') }}</label>
            <input
              id="password"
              name="password"
              type="password"
              required
              autocomplete="current-password"
              class="block w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="••••••••"
            />
          </div>

          <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm select-none">
              <input
                type="checkbox"
                name="remember"
                class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500"
              />
              {{ t('remember') }}
            </label>
            <a
              href="#"
              class="text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300"
            >
              {{ t('forgot') }}
            </a>
          </div>

          <div class="hidden rounded-md border border-red-300 bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-200 px-3 py-2 text-sm">
            Credenciais inválidas.
          </div>

          <button
            type="submit"
            class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-indigo-600 text-white px-4 py-2.5 font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          >
            <span>{{ t('entry') }}</span>
          </button>

          <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
            Esta é apenas a interface. A lógica de autenticação será aplicada depois.
          </p>
        </form>
      </div>

      <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        {{ t('not_account') }}
        <a href="#" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
          {{ t('create_account') }}
        </a>
      </p>
    </div>
  </div>
</template>

<style scoped>

</style>
