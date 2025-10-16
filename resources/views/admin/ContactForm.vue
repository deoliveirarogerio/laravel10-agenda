<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useContactsStore } from '../../js/contacts_store'

const store = useContactsStore()
const route = useRoute()
const router = useRouter()

const isEdit = !!route.params.id
const form = ref({
  contact_name: '',
  contact_email: '',
  contact_phone: '',
  cep: '',
  state: '',
  city: '',
  neighborhood: '',
  address: '',
  number: '',
})

const loading = ref(false)
const error = ref(null)

onMounted(async () => {
  if (isEdit) {
    loading.value = true
    try {
      const data = await store.find(route.params.id)
      Object.assign(form.value, data)
    } catch (e) {
      error.value = 'Erro ao carregar contato.'
    } finally {
      loading.value = false
    }
  }
})

async function submit() {
  loading.value = true
  error.value = null
  try {
    if (isEdit) {
      await store.update(route.params.id, form.value)
    } else {
      await store.create(form.value)
    }
    router.push({ name: 'admin.contacts' })
  } catch (e) {
    error.value = 'Erro ao salvar contato.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="max-w-xl mx-auto bg-white dark:bg-gray-900 p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">
      {{ isEdit ? 'Editar Contato' : 'Novo Contato' }}
    </h2>
    <form @submit.prevent="submit" class="space-y-4">
      <div v-if="error" class="text-red-600 dark:text-red-400">{{ error }}</div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">Nome</label>
          <input v-model="form.contact_name" required class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">E-mail</label>
          <input v-model="form.contact_email" type="email" required class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
          <input v-model="form.contact_phone" class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">CEP</label>
          <input v-model="form.cep" class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">Estado</label>
          <input v-model="form.state" class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">Cidade</label>
          <input v-model="form.city" class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">Bairro</label>
          <input v-model="form.neighborhood" class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">Endereço</label>
          <input v-model="form.address" class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">Número</label>
          <input v-model="form.number" class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" />
        </div>
      </div>
      <div class="flex justify-end gap-2 mt-4">
        <button type="button" @click="router.back()" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600">
          Cancelar
        </button>
        <button type="submit" :disabled="loading" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
          {{ loading ? 'Salvando...' : 'Salvar' }}
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>

</style>
