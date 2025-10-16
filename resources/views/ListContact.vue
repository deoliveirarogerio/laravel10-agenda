<script setup>
import { useContactsStore } from '../js/contacts_store'

const store = useContactsStore()
</script>

<template>
  <div class="flex justify-center items-start min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
    <div class="w-full max-w-7xl mx-auto p-6 bg-white dark:bg-gray-900 rounded shadow">
      <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100 text-center">Lista de Contatos</h3>
      <div v-if="store.loading" class="text-gray-700 dark:text-gray-300 text-center">Carregando...</div>
      <div v-else-if="store.lastError" class="text-red-600 dark:text-red-400 text-center">Erro ao carregar contatos: {{ store.lastError }}</div>
      <div v-else>
        <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded shadow-sm bg-white dark:bg-gray-900">
          <thead>
            <tr class="bg-gray-100 dark:bg-gray-800">
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">Nome</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">E-mail</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">Telefone</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">CEP</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">Estado</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">Cidade</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">Bairro</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">Endereço</th>
              <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">Número</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contact in store.items" :key="contact.id" class="hover:bg-gray-50 dark:hover:bg-gray-800">
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.contact_name }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.contact_email }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.contact_phone }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.cep }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.state }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.city }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.neighborhood }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.address }}
              </td>
              <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ contact.number }}
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="store.pagination.total > store.items.length" class="mt-4 flex items-center justify-center text-gray-700 dark:text-gray-300">
          Página {{ store.pagination.current_page }} de {{ store.pagination.last_page }}
          <button
            v-if="store.pagination.current_page > 1"
            @click="store.fetch(store.pagination.current_page - 1)"
            class="ml-4 px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600"
          >Anterior</button>
          <button
            v-if="store.pagination.current_page < store.pagination.last_page"
            @click="store.fetch(store.pagination.current_page + 1)"
            class="ml-2 px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600"
          >Próxima</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
