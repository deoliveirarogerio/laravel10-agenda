import { createRouter, createWebHistory } from 'vue-router'
import ListContact from '../views/ListContact.vue'
import { onMounted } from 'vue'
import { useContactsStore } from '../../js/contacts_store'
import { useI18n } from 'vue-i18n'

const store = useContactsStore()
const { t } = useI18n()

const routes = [
  { path: '/', name: 'contacts', component: ListContact },
]

onMounted(() => {
  store.fetch()
})

export default createRouter({
  history: createWebHistory(),
  routes,
})
