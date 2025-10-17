<script setup>
import { onMounted, computed } from 'vue';
import { useContactsStore } from '../../js/contacts_store';
import { useI18n } from 'vue-i18n';

const store = useContactsStore()

onMounted(() => {
  store.fetch()
})

const { t } = useI18n()

function removerContato(id) {
  if (confirm('Deseja remover este contato?')) {
    store.remove(id)
  }
}

const allChecked = computed({
  get: () => Array.isArray(store.items) && store.items.length > 0 && store.items.every(i => i && typeof i.id !== 'undefined' && store.selected.has(i.id)),
  set: (val) => {
    if (!Array.isArray(store.items)) return
    if (val) {
      store.items.forEach(i => { if (i && typeof i.id !== 'undefined') store.selected.add(i.id) })
    } else {
      store.clearSelection()
    }
  }
})
</script>

<template>
  <div class="w-full max-w-7x1">
    <div class="flex justify-between items-center mb-4">
      <!-- <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Lista de Contatos</h3> -->
      <router-link
        :to="{ name: 'admin.contacts.new' }"
        class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
      >
        {{ t('new_contact') }}
      </router-link>
    </div>

    <!-- Botão Exportar CSV (usa seleção do store) -->
    <div class="mb-3">
      <button
        class="px-4 py-2 rounded-md bg-gray-700 text-white shadow-sm hover:bg-gray-600 disabled:opacity-50"
        :disabled="store.selected.size === 0"
        @click="store.exportCsv()"
      >
        {{ t('export') }} CSV ({{ store.selected.size }})
      </button>
    </div>

    <div v-if="store.loading" class="text-gray-700 dark:text-gray-300">Carregando...</div>
    <div v-else-if="store.lastError" class="text-red-600 dark:text-red-400">Erro ao carregar contatos: {{ store.lastError }}</div>
    <div v-else>
      <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded shadow-sm bg-white dark:bg-gray-900">
        <thead>
           <tr class="bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left w-10">
              <input
                type="checkbox"
                v-model="allChecked"
                aria-label="Selecionar todos"
              />
            </th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('name') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('email') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('phone') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('cep') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('state') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('city') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('neighborhood') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('address') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('number') }}</th>
            <th class="px-2 py-2 border-b border-gray-300 dark:border-gray-700 text-left">{{ t('actions') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(contact, idx) in store.items"
            :key="contact?.id ?? idx"
            class="hover:bg-gray-50 dark:hover:bg-gray-800"
          >
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700">
              <input
                v-if="contact && typeof contact.id !== 'undefined'"
                type="checkbox"
                :checked="store.selected.has(contact.id)"
                @change="store.toggleSelect(contact.id)"
                :aria-label="`Selecionar contato #${contact.id}`"
              />
            </td>

            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.contact_name ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.contact_email ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.contact_phone ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.cep ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.state ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.city ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.neighborhood ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.address ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
              {{ contact?.number ?? '—' }}
            </td>
            <td class="px-2 py-2 border-b border-gray-200 dark:border-gray-700">
              <router-link
                v-if="contact && typeof contact.id !== 'undefined'"
                :to="{ name: 'admin.contacts.edit', params: { id: contact.id } }"
                class="text-blue-600 hover:underline mr-2 text-sm"
              >{{ t('edit') }}</router-link>
              <button
                v-if="contact && typeof contact.id !== 'undefined'"
                @click="removerContato(contact.id)"
                class="text-red-600 hover:underline text-sm cursor-pointer"
              >{{ t('remove') }}</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div
        v-if="(store.pagination?.total ?? 0) > (store.items?.length ?? 0)"
        class="mt-4 flex items-center text-gray-700 dark:text-gray-300"
      >
        {{ t('page')}} {{ store.pagination?.current_page ?? 1 }} {{ t('of')}} {{ store.pagination?.last_page ?? 1 }}
        <button
          v-if="(store.pagination?.current_page ?? 1) > 1"
          @click="store.fetch(store.pagination.current_page - 1)"
          class="ml-4 px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600"
        >{{ t('previous') }}</button>
        <button
          v-if="(store.pagination?.current_page ?? 1) < (store.pagination?.last_page ?? 1)"
          @click="store.fetch(store.pagination.current_page + 1)"
          class="ml-2 px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600"
        >{{ t('next') }}</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
