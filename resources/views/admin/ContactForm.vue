<script setup>
import { reactive, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useContactsStore } from '../../js/contacts_store';

const route = useRoute();
const router = useRouter();
const store = useContactsStore();

const id = route.params.id ? Number(route.params.id) : null;

const form = reactive({
  cep: '',
  state: '',
  city: '',
  neighborhood: '',
  address: '',
  number: '',
  contact_name: '',
  contact_email: '',
  contact_phone: '',
});

const errors = reactive({});

// Lista de UFs (combobox Estado)
const states = [
  'AC','AL','AP','AM','BA','CE','DF','ES','GO','MA',
  'MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN',
  'RS','RO','RR','SC','SP','SE','TO'
];

onMounted(async () => {
  if (id) {
    const data = await store.find(id);
    Object.assign(form, data || {});
  }
});

// ViaCEP no blur do CEP
async function onCepBlur() {
  const data = await store.fetchViaCep(form.cep || '');
  if (!data) return;
  // Mapear campos do store para o seu form
  form.cep = data.zip_code || form.cep;
  form.state = data.state || form.state;
  form.city = data.city || form.city;
  form.neighborhood = data.district || form.neighborhood;
  form.address = data.address || form.address;
}

async function submit() {
  Object.keys(errors).forEach(k => delete errors[k]);
  try {
    if (id) await store.update(id, form);
    else await store.create(form);
    router.push({ name: 'admin.contacts' });
  } catch (e) {
    if (e?.response?.status === 422) Object.assign(errors, e.response.data.errors || {});
  }
}
</script>

<template>
  <div class="max-w-3xl">
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-4 dark:bg-gray-800 dark:border-gray-700">
      <h2 class="text-lg font-semibold mb-4">{{ id ? 'Editar contato' : 'Novo contato' }}</h2>

      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="block text-sm mb-1">CEP</label>
            <input
              v-model="form.cep"
              @blur="onCepBlur"
              placeholder="00000-000"
              class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
            />
            <p v-if="errors.cep" class="text-sm text-red-600 mt-1">{{ errors.cep[0] }}</p>
          </div>

          <div>
            <label class="block text-sm mb-1">Estado</label>
            <select
              v-model="form.state"
              class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
            >
              <option disabled value="">Selecione</option>
              <option v-for="uf in states" :key="uf" :value="uf">{{ uf }}</option>
            </select>
            <p v-if="errors.state" class="text-sm text-red-600 mt-1">{{ errors.state[0] }}</p>
          </div>

          <div>
            <label class="block text-sm mb-1">Cidade</label>
            <input v-model="form.city" class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" />
            <p v-if="errors.city" class="text-sm text-red-600 mt-1">{{ errors.city[0] }}</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="block text-sm mb-1">Bairro</label>
            <input v-model="form.neighborhood" class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" />
            <p v-if="errors.neighborhood" class="text-sm text-red-600 mt-1">{{ errors.neighborhood[0] }}</p>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm mb-1">Endereço</label>
            <input v-model="form.address" class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" />
            <p v-if="errors.address" class="text-sm text-red-600 mt-1">{{ errors.address[0] }}</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="block text-sm mb-1">Número</label>
            <input v-model="form.number" class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" />
            <p v-if="errors.number" class="text-sm text-red-600 mt-1">{{ errors.number[0] }}</p>
          </div>
          <div>
            <label class="block text-sm mb-1">Nome</label>
            <input v-model="form.contact_name" class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" />
            <p v-if="errors.contact_name" class="text-sm text-red-600 mt-1">{{ errors.contact_name[0] }}</p>
          </div>
          <div>
            <label class="block text-sm mb-1">E-mail</label>
            <input type="email" v-model="form.contact_email" class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" />
            <p v-if="errors.contact_email" class="text-sm text-red-600 mt-1">{{ errors.contact_email[0] }}</p>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1">Telefone</label>
          <input v-model="form.contact_phone" class="w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" />
          <p v-if="errors.contact_phone" class="text-sm text-red-600 mt-1">{{ errors.contact_phone[0] }}</p>
        </div>

        <div class="flex justify-end gap-2">
          <router-link :to="{ name: 'admin.contacts' }" class="px-3 py-2 rounded-md border border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">Cancelar</router-link>
          <button class="px-3 py-2 rounded-md bg-indigo-600 text-white shadow-sm hover:bg-indigo-500">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</template>
